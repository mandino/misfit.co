<?php

/**
 * The class used to make most Dropbox API calls.  You can use this once you've gotten an
 * {@link AccessToken} via {@link WebAuth}.
 *
 * This class is stateless so it can be shared/reused.
 */
class Dropbox_Client
{
    /**
     * The access token used by this client to make authenticated API calls.  You can get an
     * access token via {@link WebAuth}.
     *
     * @return string AccessToken
     */
    function getAccessToken() { return $this->accessToken; }

    /** @var string AccessToken */
    private $accessToken;

    /**
     * An identifier for the API client, typically of the form "Name/Version".
     * This is used to set the HTTP <code>User-Agent</code> header when making API requests.
     * Example: <code>"PhotoEditServer/1.3"</code>
     *
     * If you're the author a higher-level library on top of the basic SDK, and the
     * "Photo Edit" app's server code is using your library to access Dropbox, you should append
     * your library's name and version to form the full identifier.  For example,
     * if your library is called "File Picker", you might set this field to:
     * <code>"PhotoEditServer/1.3 FilePicker/0.1-beta"</code>
     *
     * The exact format of the <code>User-Agent</code> header is described in
     * <a href="http://tools.ietf.org/html/rfc2616#section-3.8">section 3.8 of the HTTP specification</a>.
     *
     * Note that underlying HTTP client may append other things to the <code>User-Agent</code>, such as
     * the name of the library being used to actually make the HTTP request (such as cURL).
     *
     * @return string
     */
    function getClientIdentifier() { return $this->clientIdentifier; }

    /** @var string */
    private $clientIdentifier;

    /**
     * The locale of the user of your application.  Some API calls return localized
     * data and error messages; this "user locale" setting determines which locale
     * the server should use to localize those strings.
     *
     * @return null|string
     */
    function getUserLocale() { return $this->userLocale; }

    /** @var null|string */
    private $userLocale;

    /**
     * The {@link Host} object that determines the hostnames we make requests to.
     *
     * @return Dropbox_Host
     */
    function getHost() { return $this->host; }

    /**
     * Constructor.
     *
     * @param string $accessToken
     *     See {@link getAccessToken()}
     * @param string $clientIdentifier
     *     See {@link getClientIdentifier()}
     * @param null|string $userLocale
     *     See {@link getUserLocale()}
     */
    function __construct($accessToken, $clientIdentifier, $userLocale = null)
    {
        self::checkAccessTokenArg("accessToken", $accessToken);
        self::checkClientIdentifierArg("clientIdentifier", $clientIdentifier);
        Dropbox_Checker::argStringNonEmptyOrNull("userLocale", $userLocale);

        $this->accessToken = $accessToken;
        $this->clientIdentifier = $clientIdentifier;
        $this->userLocale = $userLocale;

        // The $host parameter is sort of internal.  We don't include it in the param list because
        // we don't want it to be included in the documentation.  Use PHP arg list hacks to get at
        // it.
        $host = null;
        if (func_num_args() == 4) {
            $host = func_get_arg(3);
            Dropbox_Host::checkArgOrNull("host", $host);
        }
        if ($host === null) {
            $host = Dropbox_Host::getDefault();
        }
        $this->host = $host;

        // These fields are redundant, but it makes these values a little more convenient
        // to access.
        $this->apiHost = $host->getApi();
        $this->contentHost = $host->getContent();
    }

    /** @var string */
    private $apiHost;
    /** @var string */
    private $contentHost;

    /**
     * Given a <code>$base</code> path for an API endpoint (for example, "/files"), append
     * a Dropbox API file path to the end of that URL.  Special characters in the file will
     * be encoded properly.
     *
     * This is for endpoints like "/files" takes the path on the URL and not as a separate
     * query or POST parameter.
     *
     * @param string $base
     * @param string $path
     * @return string
     */
    function appendFilePath($base, $path)
    {
        return $base . "/auto/" . rawurlencode(substr($path, 1));
    }

    /**
     * Make an API call to disable the access token that you constructed this <code>Client</code>
     * with.  After calling this, API calls made with this <code>Client</code> will fail.
     *
     * See <a href="https://www.dropbox.com/developers/core/docs#disable-token">/disable_access_token</a>.
     *
     * @throws Dropbox_Exception
     */
    function disableAccessToken()
    {
        $response = $this->doPost($this->apiHost, "1/disable_access_token");
        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);
    }

    /**
     * Make an API call to get basic account and quota information.
     *
     * <code>
     * $client = ...
     * $accountInfo = $client->getAccountInfo();
     * print_r($accountInfo);
     * </code>
     *
     * @return array
     *    See <a href="https://www.dropbox.com/developers/core/docs#account-info">/account/info</a>.
     *
     * @throws Dropbox_Exception
     */
    function getAccountInfo()
    {
        $response = $this->doGet($this->apiHost, "1/account/info");
        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);
        return Dropbox_RequestUtil::parseResponseJson($response->body);
    }

    /**
     * Downloads a file from Dropbox.  The file's contents are written to the
     * given <code>$outStream</code> and the file's metadata is returned.
     *
     * <code>
     * $client = ...;
     * $fd = fopen("./Frog.jpeg", "wb");
     * $metadata = $client->getFile("/Photos/Frog.jpeg", $fd);
     * fclose($fd);
     * print_r($metadata);
     * </code>
     *
     * @param string $path
     *   The path to the file on Dropbox (UTF-8).
     *
     * @param resource $outStream
     *   If the file exists, the file contents will be written to this stream.
     *
     * @param string|null $rev
     *   If you want the latest revision of the file at the given path, pass in <code>null</code>.
     *   If you want a specific version of a file, pass in value of the file metadata's "rev" field.
     *
     * @return null|array
     *   The <a href="https://www.dropbox.com/developers/core/docs#metadata-details">metadata
     *   object</a> for the file at the given $path and $rev, or <code>null</code> if the file
     *   doesn't exist,
     *
     * @throws Dropbox_Exception
     */
    function getFile($path, $outStream, $rev = null)
    {
        Dropbox_Path::checkArgNonRoot("path", $path);
        Dropbox_Checker::argResource("outStream", $outStream);
        Dropbox_Checker::argStringNonEmptyOrNull("rev", $rev);

        $url = $this->buildUrlForGetOrPut(
            $this->contentHost,
            $this->appendFilePath("1/files", $path),
            array("rev" => $rev));

        $curl = $this->mkCurl($url);
        $metadataCatcher = new Dropbox_DropboxMetadataHeaderCatcher($curl->handle);
        $streamRelay = new Dropbox_CurlStreamRelay($curl->handle, $outStream);

        $response = $curl->exec();

        if ($response->statusCode === 404) return null;

        if ($response->statusCode !== 200) {
            $response->body = $streamRelay->getErrorBody();
            throw Dropbox_RequestUtil::unexpectedStatus($response);
        }

        return $metadataCatcher->getMetadata();
    }

    /**
     * Calling 'uploadFile' with <code>$numBytes</code> less than this value, will cause this SDK
     * to use the standard /files_put endpoint.  When <code>$numBytes</code> is greater than this
     * value, we'll use the /chunked_upload endpoint.
     *
     * @var int
     */
    public static $AUTO_CHUNKED_UPLOAD_THRESHOLD = 9863168;  // 8 MB

    /**
     * @var int
     */
    public static $DEFAULT_CHUNK_SIZE = 4194304;  // 4 MB

    /**
     * Creates a file on Dropbox, using the data from <code>$inStream</code> for the file contents.
     *
     * <code>
     * use \Dropbox as dbx;
     * $client = ...;
     * $fd = fopen("./frog.jpeg", "rb");
     * $md1 = $client->uploadFile("/Photos/Frog.jpeg",
     *                            dbx\WriteMode::add(), $fd);
     * fclose($fd);
     * print_r($md1);
     * $rev = $md1["rev"];
     *
     * // Re-upload with WriteMode::update(...), which will overwrite the
     * // file if it hasn't been modified from our original upload.
     * $fd = fopen("./frog-new.jpeg", "rb");
     * $md2 = $client->uploadFile("/Photos/Frog.jpeg",
     *                            dbx\WriteMode::update($rev), $fd);
     * fclose($fd);
     * print_r($md2);
     * </code>
     *
     * @param string $path
     *    The Dropbox path to save the file to (UTF-8).
     *
     * @param Dropbox_WriteMode $writeMode
     *    What to do if there's already a file at the given path.
     *
     * @param resource $inStream
     *    The data to use for the file contents.
     *
     * @param int|null $numBytes
     *    You can pass in <code>null</code> if you don't know.  If you do provide the size, we can
     *    perform a slightly more efficient upload (fewer network round-trips) for files smaller
     *    than 8 MB.
     *
     * @param Callable|null $callback
     *    Curl progress callback.
     *
     * @return mixed
     *    The <a href="https://www.dropbox.com/developers/core/docs#metadata-details>metadata
     *    object</a> for the newly-added file.
     *
     * @throws Dropbox_Exception
     */
    function uploadFile($path, $writeMode, $inStream, $numBytes = null, $callback = null)
    {
        Dropbox_Path::checkArgNonRoot("path", $path);
        Dropbox_WriteMode::checkArg("writeMode", $writeMode);
        Dropbox_Checker::argResource("inStream", $inStream);
        Dropbox_Checker::argNatOrNull("numBytes", $numBytes);

        if ($callback !== null) {
            Dropbox_Checker::argCallable("callback", $callback);
        }

        // If we don't know how many bytes are coming, we have to use chunked upload.
        // If $numBytes is large, we elect to use chunked upload.
        // In all other cases, use regular upload.
        if ($numBytes === null || $numBytes > self::$AUTO_CHUNKED_UPLOAD_THRESHOLD) {
            $metadata = $this->_uploadFileChunked($path, $writeMode, $inStream, $numBytes,
                                                  self::$DEFAULT_CHUNK_SIZE, $callback);
        } else {
            $config = new Dropbox_Closure_CurlConfigInStream($inStream, $numBytes);
            $metadata = $this->_uploadFile($path, $writeMode, $config, $callback);
        }

        return $metadata;
    }

    /**
     * Creates a file on Dropbox, using the given $data string as the file contents.
     *
     * <code>
     * use \Dropbox as dbx;
     * $client = ...;
     * $md = $client->uploadFileFromString("/Grocery List.txt",
     *                                     dbx\WriteMode::add(),
     *                                     "1. Coke\n2. Popcorn\n3. Toothpaste\n");
     * print_r($md);
     * </code>
     *
     * @param string $path
     *    The Dropbox path to save the file to (UTF-8).
     *
     * @param Dropbox_WriteMode $writeMode
     *    What to do if there's already a file at the given path.
     *
     * @param string $data
     *    The data to use for the contents of the file.
     *
     * @return mixed
     *    The <a href="https://www.dropbox.com/developers/core/docs#metadata-details>metadata
     *    object</a> for the newly-added file.
     *
     * @throws Dropbox_Exception
     */
    function uploadFileFromString($path, $writeMode, $data)
    {
        Dropbox_Path::checkArgNonRoot("path", $path);
        Dropbox_WriteMode::checkArg("writeMode", $writeMode);
        Dropbox_Checker::argString("data", $data);

        $config = new Dropbox_Closure_CurlConfigOctetStream($data);
        return $this->_uploadFile($path, $writeMode, $config);
    }

    /**
     * Creates a file on Dropbox, using the data from $inStream as the file contents.
     *
     * This version of <code>uploadFile</code> splits uploads the file ~4MB chunks at a time and
     * will retry a few times if one chunk fails to upload.  Uses {@link chunkedUploadStart()},
     * {@link chunkedUploadContinue()}, and {@link chunkedUploadFinish()}.
     *
     * @param string $path
     *    The Dropbox path to save the file to (UTF-8).
     *
     * @param Dropbox_WriteMode $writeMode
     *    What to do if there's already a file at the given path.
     *
     * @param resource $inStream
     *    The data to use for the file contents.
     *
     * @param int|null $numBytes
     *    The number of bytes available from $inStream.
     *    You can pass in <code>null</code> if you don't know.
     *
     * @param int|null $chunkSize
     *    The number of bytes to upload in each chunk.  You can omit this (or pass in
     *    <code>null</code> and the library will use a reasonable default.
     *
     * @return mixed
     *    The <a href="https://www.dropbox.com/developers/core/docs#metadata-details>metadata
     *    object</a> for the newly-added file.
     *
     * @throws Dropbox_Exception
     */
    function uploadFileChunked($path, $writeMode, $inStream, $numBytes = null, $chunkSize = null)
    {
        if ($chunkSize === null) {
            $chunkSize = self::$DEFAULT_CHUNK_SIZE;
        }

        Dropbox_Path::checkArgNonRoot("path", $path);
        Dropbox_WriteMode::checkArg("writeMode", $writeMode);
        Dropbox_Checker::argResource("inStream", $inStream);
        Dropbox_Checker::argNatOrNull("numBytes", $numBytes);
        Dropbox_Checker::argIntPositive("chunkSize", $chunkSize);

        return $this->_uploadFileChunked($path, $writeMode, $inStream, $numBytes, $chunkSize);
    }

    /**
     * @param string $path
     *
     * @param Dropbox_WriteMode $writeMode
     *    What to do if there's already a file at the given path (UTF-8).
     *
     * @param resource $inStream
     *    The source of data to upload.
     *
     * @param int|null $numBytes
     *    You can pass in <code>null</code>.  But if you know how many bytes you expect, pass in
     *    that value and this function will do a sanity check at the end to make sure the number of
     *    bytes read from $inStream matches up.
     *
     * @param int $chunkSize
     *
     * @return array
     *    The <a href="https://www.dropbox.com/developers/core/docs#metadata-details>metadata
     *    object</a> for the newly-added file.
     *
     * @throws InvalidArgumentException
     * @throws Dropbox_Exception_BadResponse
     */
    private function _uploadFileChunked($path, $writeMode, $inStream, $numBytes, $chunkSize, $callback = null)
    {
        Dropbox_Path::checkArg("path", $path);
        Dropbox_WriteMode::checkArg("writeMode", $writeMode);
        Dropbox_Checker::argResource("inStream", $inStream);
        Dropbox_Checker::argNatOrNull("numBytes", $numBytes);
        Dropbox_Checker::argNat("chunkSize", $chunkSize);

        if ($callback !== null) {
            Dropbox_Checker::argCallable("callback", $callback);
        }

        // NOTE: This function performs 3 retries on every call.  This is maybe not the right
        // layer to make retry decisions.  It's also awkward because none of the other calls
        // perform retries.

        assert($chunkSize > 0);

        $data = self::readFully($inStream, $chunkSize);
        $len = strlen($data);

        $client = $this;
        $uploadStart = new Dropbox_Closure_ChunkedUploadStartAction($client, $data, $callback);
        $uploadId = Dropbox_RequestUtil::runWithRetry(3, $uploadStart);
        unset($uploadStart);

        $byteOffset = $len;

        while (!feof($inStream)) {
            unset($data);
            $data = self::readFully($inStream, $chunkSize);
            $len = strlen($data);

            while (true) {
                $uploadContinue = new Dropbox_Closure_ChunkedUploadContinueAction($client, $uploadId, $byteOffset, $data, $callback);
                $r = Dropbox_RequestUtil::runWithRetry(3, $uploadContinue);
                unset($uploadContinue);

                if ($r === true) {  // Chunk got uploaded!
                    $byteOffset += $len;
                    break;
                }
                if ($r === false) {  // Server didn't recognize our upload ID
                    // This is very unlikely since we're uploading all the chunks in sequence.
                    throw new Dropbox_Exception_BadResponse("Server forgot our uploadId");
                }

                // Otherwise, the server is at a different byte offset from us.
                $serverByteOffset = $r;
                assert($serverByteOffset !== $byteOffset);  // chunkedUploadContinue ensures this.
                // An earlier byte offset means the server has lost data we sent earlier.
                if ($serverByteOffset < $byteOffset) throw new Dropbox_Exception_BadResponse(
                    "Server is at an ealier byte offset: us=$byteOffset, server=$serverByteOffset");
                $diff = $serverByteOffset - $byteOffset;
                // If the server is past where we think it could possibly be, something went wrong.
                if ($diff > $len) throw new Dropbox_Exception_BadResponse(
                    "Server is more than a chunk ahead: us=$byteOffset, server=$serverByteOffset");
                // The normal case is that the server is a bit further along than us because of a
                // partially-uploaded chunk.  Finish it off.
                $byteOffset += $diff;
                if ($diff === $len) break;  // If the server is at the end, we're done.
                $data = substr($data, $diff);
            }
        }

        if ($numBytes !== null && $byteOffset !== $numBytes) throw new InvalidArgumentException(
            "You passed numBytes=$numBytes but the stream had $byteOffset bytes.");

        $uploadFinish = new Dropbox_Closure_ChunkedUploadFinishAction($client, $uploadId, $path, $writeMode);
        $metadata = Dropbox_RequestUtil::runWithRetry(3, $uploadFinish);

        return $metadata;
    }

    /**
     * Sometimes fread() returns less than the request number of bytes (for example, when reading
     * from network streams).  This function repeatedly calls fread until the requested number of
     * bytes have been read or we've reached EOF.
     *
     * @param resource $inStream
     * @param int $numBytes
     * @throws Dropbox_StreamReadException
     * @return string
     */
    private static function readFully($inStream, $numBytes)
    {
        Dropbox_Checker::argNat("numBytes", $numBytes);

        $full = '';
        $bytesRemaining = $numBytes;
        while (!feof($inStream) && $bytesRemaining > 0) {
            $part = fread($inStream, $bytesRemaining);
            if ($part === false) throw new Dropbox_StreamReadException("Error reading from \$inStream.");
            if ($full === '') {
                $full = $part;
            } else {
                $full .= $part;
            }
            $bytesRemaining -= strlen($part);
        }
        return $full;
    }

    /**
     * @param string $path
     * @param Dropbox_WriteMode $writeMode
     * @param Dropbox_Closure_CurlConfigInterface $curlConfigClosure
     * @return array
     *
     * @throws Dropbox_Exception
     */
    private function _uploadFile($path, $writeMode, Dropbox_Closure_CurlConfigInterface $curlConfigClosure, $callback = null)
    {
        Dropbox_Path::checkArg("path", $path);
        Dropbox_WriteMode::checkArg("writeMode", $writeMode);

        $url = $this->buildUrlForGetOrPut(
            $this->contentHost,
            $this->appendFilePath("1/files_put", $path),
            $writeMode->getExtraParams());

        $curl = $this->mkCurl($url);

        $curlConfigClosure->configure($curl);

        if ($callback) {
            $curl->set(CURLOPT_NOPROGRESS, false);
            $curl->set(CURLOPT_PROGRESSFUNCTION, $callback);
        }

        $curl->set(CURLOPT_RETURNTRANSFER, true);
        $response = $curl->exec();

        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        return Dropbox_RequestUtil::parseResponseJson($response->body);
    }

    /**
     * Start a new chunked upload session and upload the first chunk of data.
     *
     * @param string $data
     *     The data to start off the chunked upload session.
     *
     * @return array
     *     A pair of <code>(string $uploadId, int $byteOffset)</code>.  <code>$uploadId</code>
     *     is a unique identifier for this chunked upload session.  You pass this in to
     *     {@link chunkedUploadContinue} and {@link chuunkedUploadFinish}.  <code>$byteOffset</code>
     *     is the number of bytes that were successfully uploaded.
     *
     * @throws Dropbox_Exception
     */
    function chunkedUploadStart($data, $callback = null)
    {
        Dropbox_Checker::argString("data", $data);

        $response = $this->_chunkedUpload(array(), $data, $callback);

        if ($response->statusCode === 404) {
            throw new Dropbox_Exception_BadResponse("Got a 404, but we didn't send up an 'upload_id'");
        }

        $correction = self::_chunkedUploadCheckForOffsetCorrection($response);
        if ($correction !== null) throw new Dropbox_Exception_BadResponse(
            "Got an offset-correcting 400 response, but we didn't send an offset");

        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        list($uploadId, $byteOffset) = self::_chunkedUploadParse200Response($response->body);
        $len = strlen($data);
        if ($byteOffset !== $len) throw new Dropbox_Exception_BadResponse(
            "We sent $len bytes, but server returned an offset of $byteOffset");

        return $uploadId;
    }

    /**
     * Append another chunk data to a previously-started chunked upload session.
     *
     * @param string $uploadId
     *     The unique identifier for the chunked upload session.  This is obtained via
     *     {@link chunkedUploadStart}.
     *
     * @param int $byteOffset
     *     The number of bytes you think you've already uploaded to the given chunked upload
     *     session.  The server will append the new chunk of data after that point.
     *
     * @param string $data
     *     The data to append to the existing chunked upload session.
     *
     * @param Callable $callback
     *
     * @return int|bool
     *     If <code>false</code>, it means the server didn't know about the given
     *     <code>$uploadId</code>.  This may be because the chunked upload session has expired
     *     (they last around 24 hours).
     *     If <code>true</code>, the chunk was successfully uploaded.  If an integer, it means
     *     you and the server don't agree on the current <code>$byteOffset</code>.  The returned
     *     integer is the server's internal byte offset for the chunked upload session.  You need
     *     to adjust your input to match.
     *
     * @throws Dropbox_Exception
     */
    function chunkedUploadContinue($uploadId, $byteOffset, $data, $callback = null)
    {
        Dropbox_Checker::argStringNonEmpty("uploadId", $uploadId);
        Dropbox_Checker::argNat("byteOffset", $byteOffset);
        Dropbox_Checker::argString("data", $data);

        $response = $this->_chunkedUpload(
            array("upload_id" => $uploadId, "offset" => $byteOffset), $data, $callback);

        if ($response->statusCode === 404) {
            // The server doesn't know our upload ID.  Maybe it expired?
            return false;
        }

        $correction = self::_chunkedUploadCheckForOffsetCorrection($response);
        if ($correction !== null) {
            list($correctedUploadId, $correctedByteOffset) = $correction;
            if ($correctedUploadId !== $uploadId) throw new Dropbox_Exception_BadResponse(
                "Corrective 400 upload_id mismatch: us=".
                self::q($uploadId)." server=".self::q($correctedUploadId));
            if ($correctedByteOffset === $byteOffset) throw new Dropbox_Exception_BadResponse(
                "Corrective 400 offset is the same as ours: $byteOffset");
            return $correctedByteOffset;
        }

        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);
        list($retUploadId, $retByteOffset) = self::_chunkedUploadParse200Response($response->body);

        $nextByteOffset = $byteOffset + strlen($data);
        if ($uploadId !== $retUploadId) throw new Dropbox_Exception_BadResponse(
                "upload_id mismatch: us=".self::q($uploadId).", server=".self::q($uploadId));
        if ($nextByteOffset !== $retByteOffset) throw new Dropbox_Exception_BadResponse(
                "next-offset mismatch: us=$nextByteOffset, server=$retByteOffset");

        return true;
    }

    /**
     * @param string $body
     * @return array
     */
    private static function _chunkedUploadParse200Response($body)
    {
        $j = Dropbox_RequestUtil::parseResponseJson($body);
        $uploadId = self::getField($j, "upload_id");
        $byteOffset = self::getField($j, "offset");
        return array($uploadId, $byteOffset);
    }

    /**
     * @param Dropbox_HttpResponse $response
     * @return array|null
     */
    private static function _chunkedUploadCheckForOffsetCorrection($response)
    {
        if ($response->statusCode !== 400) return null;
        $j = json_decode($response->body, true);
        if ($j === null) return null;
        if (!array_key_exists("upload_id", $j) || !array_key_exists("offset", $j)) return null;
        $uploadId = $j["upload_id"];
        $byteOffset = $j["offset"];
        return array($uploadId, $byteOffset);
    }

    /**
     * Creates a file on Dropbox using the accumulated contents of the given chunked upload session.
     *
     * See <a href="https://www.dropbox.com/developers/core/docs#commit-chunked-upload">/commit_chunked_upload</a>.
     *
     * @param string $uploadId
     *     The unique identifier for the chunked upload session.  This is obtained via
     *     {@link chunkedUploadStart}.
     *
     * @param string $path
     *    The Dropbox path to save the file to ($path).
     *
     * @param Dropbox_WriteMode $writeMode
     *    What to do if there's already a file at the given path.
     *
     * @return array|null
     *    If <code>null</code>, it means the Dropbox server wasn't aware of the
     *    <code>$uploadId</code> you gave it.
     *    Otherwise, you get back the
     *    <a href="https://www.dropbox.com/developers/core/docs#metadata-details">metadata object</a>
     *    for the newly-created file.
     *
     * @throws Dropbox_Exception
     */
    function chunkedUploadFinish($uploadId, $path, $writeMode)
    {
        Dropbox_Checker::argStringNonEmpty("uploadId", $uploadId);
        Dropbox_Path::checkArgNonRoot("path", $path);
        Dropbox_WriteMode::checkArg("writeMode", $writeMode);

        $params = array_merge(array("upload_id" => $uploadId), $writeMode->getExtraParams());

        $response = $this->doPost(
            $this->contentHost,
            $this->appendFilePath("1/commit_chunked_upload", $path),
            $params);

        if ($response->statusCode === 404) return null;
        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        return Dropbox_RequestUtil::parseResponseJson($response->body);
    }

    /**
     * @param array $params
     * @param string $data
     * @param callable $callback
     *
     * @return Dropbox_HttpResponse
     */
    protected function _chunkedUpload($params, $data, $callback = null)
    {
        $url = $this->buildUrlForGetOrPut(
            $this->contentHost, "1/chunked_upload", $params);

        $curl = $this->mkCurl($url);

        // We can't use CURLOPT_PUT because it wants a stream, but we already have $data in memory.
        $curl->set(CURLOPT_CUSTOMREQUEST, "PUT");
        $curl->set(CURLOPT_POSTFIELDS, $data);
        $curl->addHeader("Content-Type: application/octet-stream");

        if ($callback) {
            $curl->set(CURLOPT_NOPROGRESS, false);
            $curl->set(CURLOPT_PROGRESSFUNCTION, $callback);
        }

        $curl->set(CURLOPT_RETURNTRANSFER, true);
        return $curl->exec();
    }

    /**
     * Returns the metadata for whatever file or folder is at the given path.
     *
     * <code>
     * $client = ...;
     * $md = $client->getMetadata("/Photos/Frog.jpeg");
     * print_r($md);
     * </code>
     *
     * @param string $path
     *    The Dropbox path to a file or folder (UTF-8).
     *
     * @return array|null
     *    If there is a file or folder at the given path, you'll get back the
     *    <a href="https://www.dropbox.com/developers/core/docs#metadata-details">metadata object</a>
     *    for that file or folder.  If not, you'll get back <code>null</code>.
     *
     * @throws Dropbox_Exception
     */
    function getMetadata($path)
    {
        Dropbox_Path::checkArg("path", $path);

        return $this->_getMetadata($path, array("list" => "false"));
    }

    /**
     * Returns the metadata for whatever file or folder is at the given path and, if it's a folder,
     * also include the metadata for all the immediate children of that folder.
     *
     * <code>
     * $client = ...;
     * $md = $client->getMetadataWithChildren("/Photos");
     * print_r($md);
     * </code>
     *
     * @param string $path
     *    The Dropbox path to a file or folder (UTF-8).
     *
     * @return array|null
     *    If there is a file or folder at the given path, you'll get back the
     *    <a href="https://www.dropbox.com/developers/core/docs#metadata-details">metadata object</a>
     *    for that file or folder, along with all immediate children if it's a folder.  If not,
     *    you'll get back <code>null</code>.
     *
     * @throws Dropbox_Exception
     */
    function getMetadataWithChildren($path)
    {
        Dropbox_Path::checkArg("path", $path);

        return $this->_getMetadata($path, array("list" => "true", "file_limit" => "25000"));
    }

    /**
     * @param string $path
     * @param array $params
     * @return array
     *
     * @throws Dropbox_Exception
     */
    private function _getMetadata($path, $params)
    {
        $response = $this->doGet(
            $this->apiHost,
            $this->appendFilePath("1/metadata", $path),
            $params);

        if ($response->statusCode === 404) return null;
        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        $metadata = Dropbox_RequestUtil::parseResponseJson($response->body);
        if (array_key_exists("is_deleted", $metadata) && $metadata["is_deleted"]) return null;
        return $metadata;
    }

    /**
     * If you've previously retrieved the metadata for a folder and its children, this method will
     * retrieve updated metadata only if something has changed.  This is more efficient than
     * calling {@link getMetadataWithChildren} if you have a cache of previous results.
     *
     * <code>
     * $client = ...;
     * $md = $client->getMetadataWithChildren("/Photos");
     * print_r($md);
     * assert($md["is_dir"], "expecting \"/Photos\" to be a folder");
     *
     * sleep(10);
     *
     * // Now see if anything changed...
     * list($changed, $new_md) = $client->getMetadataWithChildrenIfChanged(
     *                                    "/Photos", $md["hash"]);
     * if ($changed) {
     *     echo "Folder changed.\n";
     *     print_r($new_md);
     * } else {
     *     echo "Folder didn't change.\n";
     * }
     * </code>
     *
     * @param string $path
     *    The Dropbox path to a folder (UTF-8).
     *
     * @param string $previousFolderHash
     *    The "hash" field from the previously retrieved folder metadata.
     *
     * @return array
     *    A <code>list(boolean $changed, array $metadata)</code>.  If the metadata hasn't changed,
     *    you'll get <code>list(false, null)</code>.  If the metadata of the folder or any of its
     *    children has changed, you'll get <code>list(true, $newMetadata)</code>.  $metadata is a
     *    <a href="https://www.dropbox.com/developers/core/docs#metadata-details">metadata object</a>.
     *
     * @throws Dropbox_Exception
     */
    function getMetadataWithChildrenIfChanged($path, $previousFolderHash)
    {
        Dropbox_Path::checkArg("path", $path);
        Dropbox_Checker::argStringNonEmpty("previousFolderHash", $previousFolderHash);

        $params = array("list" => "true", "file_limit" => "25000", "hash" => $previousFolderHash);

        $response = $this->doGet(
            $this->apiHost,
            $this->appendFilePath("1/metadata", $path),
            $params);

        if ($response->statusCode === 304) return array(false, null);
        if ($response->statusCode === 404) return array(true, null);
        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        $metadata = Dropbox_RequestUtil::parseResponseJson($response->body);
        if (array_key_exists("is_deleted", $metadata) && $metadata["is_deleted"]) {
            return array(true, null);
        }
        return array(true, $metadata);
    }

    /**
     * A way of letting you keep up with changes to files and folders in a user's Dropbox.
     *
     * @param string|null $cursor
     *    If this is the first time you're calling this, pass in <code>null</code>.  Otherwise,
     *    pass in whatever cursor was returned by the previous call.
     *
     * @param string|null $pathPrefix
     *    If <code>null</code>, you'll get results for the entire folder (either the user's
     *    entire Dropbox or your App Folder).  If you set <code>$path_prefix</code> to
     *    "/Photos/Vacation", you'll only get results for that path and any files and folders
     *    under it.
     *
     * @return array
     *    A <a href="https://www.dropbox.com/developers/core/docs#delta">delta page</a>, which
     *    contains a list of changes to apply along with a new "cursor" that should be passed into
     *    future <code>getDelta</code> calls.  If the "reset" field is <code>true</code>, you
     *    should clear your local state before applying the changes.  If the "has_more" field is
     *    <code>true</code>, call <code>getDelta</code> immediately to get more results, otherwise
     *    wait a while (at least 5 minutes) before calling <code>getDelta</code> again.
     *
     * @throws Dropbox_Exception
     */
    function getDelta($cursor = null, $pathPrefix = null)
    {
        Dropbox_Checker::argStringNonEmptyOrNull("cursor", $cursor);
        Dropbox_Path::checkArgOrNull("pathPrefix", $pathPrefix);

        $response = $this->doPost($this->apiHost, "1/delta", array(
            "cursor" => $cursor,
            "path_prefix" => $pathPrefix));

        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        return Dropbox_RequestUtil::parseResponseJson($response->body);
    }

    /**
     * Gets the metadata for all the file revisions (up to a limit) for a given path.
     *
     * See <a href="https://www.dropbox.com/developers/core/docs#revisions">/revisions</a>.
     *
     * @param string $path
     *    The Dropbox path that you want file revision metadata for (UTF-8).
     *
     * @param int|null limit
     *    The maximum number of revisions to return.
     *
     * @return array|null
     *    A list of <a href="https://www.dropbox.com/developers/core/docs#metadata-details>metadata
     *    objects</a>, one for each file revision.  The later revisions appear first in the list.
     *    If <code>null</code>, then there were too many revisions at that path.
     *
     * @throws Dropbox_Exception
     */
    function getRevisions($path, $limit = null)
    {
        Dropbox_Path::checkArgNonRoot("path", $path);
        Dropbox_Checker::argIntPositiveOrNull("limit", $limit);

        $response = $this->doGet(
            $this->apiHost,
            $this->appendFilePath("1/revisions", $path),
            array("rev_limit" => $limit));

        if ($response->statusCode === 406) return null;
        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        return Dropbox_RequestUtil::parseResponseJson($response->body);
    }

    /**
     * Takes a copy of the file at the given revision and saves it over the current copy.  This
     * will create a new revision, but the file contents will match the revision you specified.
     *
     * See <a href="https://www.dropbox.com/developers/core/docs#restore">/restore</a>.
     *
     * @param string $path
     *    The Dropbox path of the file to restore (UTF-8).
     *
     * @param string $rev
     *    The revision to restore the contents to.
     *
     * @return mixed
     *    The <a href="https://www.dropbox.com/developers/core/docs#metadata-details">metadata
     *    object</a>
     *
     * @throws Dropbox_Exception
     */
    function restoreFile($path, $rev)
    {
        Dropbox_Path::checkArgNonRoot("path", $path);
        Dropbox_Checker::argStringNonEmpty("rev", $rev);

        $response = $this->doPost(
            $this->apiHost,
            $this->appendFilePath("1/restore", $path),
            array("rev" => $rev));

        if ($response->statusCode === 404) return null;
        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        return Dropbox_RequestUtil::parseResponseJson($response->body);
    }

    /**
     * Returns metadata for all files and folders whose filename matches the query string.
     *
     * See <a href="https://www.dropbox.com/developers/core/docs#search">/search</a>.
     *
     * @param string $basePath
     *    The path to limit the search to (UTF-8).  Pass in "/" to search everything.
     *
     * @param string $query
     *    A space-separated list of substrings to search for.  A file matches only if it contains
     *    all the substrings.
     *
     * @param int|null $limit
     *    The maximum number of results to return.
     *
     * @param bool $includeDeleted
     *    Whether to include deleted files in the results.
     *
     * @return mixed
     *    A list of <a href="https://www.dropbox.com/developers/core/docs#metadata-details>metadata
     *    objects</a> of files that match the search query.
     *
     * @throws Dropbox_Exception
     */
    function searchFileNames($basePath, $query, $limit = null, $includeDeleted = false)
    {
        Dropbox_Path::checkArg("basePath", $basePath);
        Dropbox_Checker::argStringNonEmpty("query", $query);
        Dropbox_Checker::argNatOrNull("limit", $limit);
        Dropbox_Checker::argBool("includeDeleted", $includeDeleted);

        $response = $this->doPost(
            $this->apiHost,
            $this->appendFilePath("1/search", $basePath),
            array(
                "query" => $query,
                "file_limit" => $limit,
                "include_deleted" => $includeDeleted,
            ));

        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        return Dropbox_RequestUtil::parseResponseJson($response->body);
    }

    /**
     * Creates and returns a public link to a file or folder's "preview page".  This link can be
     * used without authentication.  The preview page may contain a thumbnail or some other
     * preview of the file, along with a download link to download the actual file.
     *
     * See <a href="https://www.dropbox.com/developers/core/docs#shares">/shares</a>.
     *
     * @param string $path
     *    The Dropbox path to the file or folder you want to create a shareable link to (UTF-8).
     *
     * @return string
     *    The URL of the preview page.
     *
     * @throws Dropbox_Exception
     */
    function createShareableLink($path)
    {
        Dropbox_Path::checkArg("path", $path);

        $response = $this->doPost(
            $this->apiHost,
            $this->appendFilePath("1/shares", $path),
            array(
                "short_url" => "false",
            ));

        if ($response->statusCode === 404) return null;
        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        $j = Dropbox_RequestUtil::parseResponseJson($response->body);
        return self::getField($j, "url");
    }

    /**
     * Creates and returns a direct link to a file.  This link can be used without authentication.
     * This link will expire in a few hours.
     *
     * See <a href="https://www.dropbox.com/developers/core/docs#media">/media</a>.
     *
     * @param string $path
     *    The Dropbox path to a file or folder (UTF-8).
     *
     * @return array
     *    A <code>list(string $url, \DateTime $expires)</code> where <code>$url</code> is a direct
     *    link to the requested file and <code>$expires</code> is a standard PHP
     *    <code>\DateTime</code> representing when <code>$url</code> will stop working.
     *
     * @throws Dropbox_Exception
     */
    function createTemporaryDirectLink($path)
    {
        Dropbox_Path::checkArgNonRoot("path", $path);

        $response = $this->doPost(
            $this->apiHost,
            $this->appendFilePath("1/media", $path));

        if ($response->statusCode === 404) return null;
        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        $j = Dropbox_RequestUtil::parseResponseJson($response->body);
        $url = self::getField($j, "url");
        $expires = self::parseDateTime(self::getField($j, "expires"));
        return array($url, $expires);
    }

    /**
     * Creates and returns a "copy ref" to a file.  A copy ref can be used to copy a file across
     * different Dropbox accounts without downloading and re-uploading.
     *
     * For example: Create a <code>Client</code> using the access token from one account and call
     * <code>createCopyRef</code>.  Then, create a <code>Client</code> using the access token for
     * another account and call <code>copyFromCopyRef</code> using the copy ref.  (You need to use
     * the same app key both times.)
     *
     * See <a href="https://www.dropbox.com/developers/core/docs#copy_ref">/copy_ref</a>.
     *
     * @param string $path
     *    The Dropbox path of the file or folder you want to create a copy ref for (UTF-8).
     *
     * @return string
     *    The copy ref (just a string that you keep track of).
     *
     * @throws Dropbox_Exception
     */
    function createCopyRef($path)
    {
        Dropbox_Path::checkArg("path", $path);

        $response = $this->doGet(
            $this->apiHost,
            $this->appendFilePath("1/copy_ref", $path));

        if ($response->statusCode === 404) return null;
        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        $j = Dropbox_RequestUtil::parseResponseJson($response->body);
        return self::getField($j, "copy_ref");
    }

    /**
     * Gets a thumbnail image representation of the file at the given path.
     *
     * See <a href="https://www.dropbox.com/developers/core/docs#thumbnails">/thumbnails</a>.
     *
     * @param string $path
     *    The path to the file you want a thumbnail for (UTF-8).
     *
     * @param string $format
     *    One of the two image formats: "jpeg" or "png".
     *
     * @param string $size
     *    One of the predefined image size names, as a string:
     *    <ul>
     *    <li>"xs" - 32x32</li>
     *    <li>"s" - 64x64</li>
     *    <li>"m" - 128x128</li>
     *    <li>"l" - 640x480</li>
     *    <li>"xl" - 1024x768</li>
     *    </ul>
     *
     * @return array|null
     *    If the file exists, you'll get <code>list(array $metadata, string $data)</code> where
     *    <code>$metadata</code> is the file's
     *    <a href="https://www.dropbox.com/developers/core/docs#metadata-details">metadata object</a>
     *    and $data is the raw data for the thumbnail image.  If the file doesn't exist, you'll
     *    get <code>null</code>.
     *
     * @throws Dropbox_Exception
     * @throws InvalidArgumentException
     */
    function getThumbnail($path, $format, $size)
    {
        Dropbox_Path::checkArgNonRoot("path", $path);
        Dropbox_Checker::argString("format", $format);
        Dropbox_Checker::argString("size", $size);
        if (!in_array($format, array("jpeg", "png"))) {
            throw new InvalidArgumentException("Invalid 'format': ".self::q($format));
        }
        if (!in_array($size, array("xs", "s", "m", "l", "xl"))) {
            throw new InvalidArgumentException("Invalid 'size': ".self::q($format));
        }

        $url = $this->buildUrlForGetOrPut(
            $this->contentHost,
            $this->appendFilePath("1/thumbnails", $path),
            array("size" => $size, "format" => $format));

        $curl = $this->mkCurl($url);
        $metadataCatcher = new Dropbox_DropboxMetadataHeaderCatcher($curl->handle);

        $curl->set(CURLOPT_RETURNTRANSFER, true);
        $response = $curl->exec();

        if ($response->statusCode === 404) return null;
        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        $metadata = $metadataCatcher->getMetadata();
        return array($metadata, $response->body);
    }

    /**
     * Copies a file or folder to a new location
     *
     * See <a href="https://www.dropbox.com/developers/core/docs#fileops-copy">/fileops/copy</a>.
     *
     * @param string $fromPath
     *    The Dropbox path of the file or folder you want to copy (UTF-8).
     *
     * @param string $toPath
     *    The destination Dropbox path (UTF-8).
     *
     * @return mixed
     *    The <a href="https://www.dropbox.com/developers/core/docs#metadata-details">metadata
     *    object</a> for the new file or folder.
     *
     * @throws Dropbox_Exception
     */
    function copy($fromPath, $toPath)
    {
        Dropbox_Path::checkArg("fromPath", $fromPath);
        Dropbox_Path::checkArgNonRoot("toPath", $toPath);

        $response = $this->doPost(
            $this->apiHost,
            "1/fileops/copy",
            array(
                "root" => "auto",
                "from_path" => $fromPath,
                "to_path" => $toPath,
            ));

        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        return Dropbox_RequestUtil::parseResponseJson($response->body);
    }

    /**
     * Creates a file or folder based on an existing copy ref (possibly from a different Dropbox
     * account).
     *
     * See <a href="https://www.dropbox.com/developers/core/docs#fileops-copy">/fileops/copy</a>.
     *
     * @param string $copyRef
     *    A copy ref obtained via the {@link createCopyRef()} call.
     *
     * @param string $toPath
     *    The Dropbox path you want to copy the file or folder to (UTF-8).
     *
     * @return mixed
     *    The <a href="https://www.dropbox.com/developers/core/docs#metadata-details">metadata
     *    object</a> for the new file or folder.
     *
     * @throws Dropbox_Exception
     */
    function copyFromCopyRef($copyRef, $toPath)
    {
        Dropbox_Checker::argStringNonEmpty("copyRef", $copyRef);
        Dropbox_Path::checkArgNonRoot("toPath", $toPath);

        $response = $this->doPost(
            $this->apiHost,
            "1/fileops/copy",
            array(
                "root" => "auto",
                "from_copy_ref" => $copyRef,
                "to_path" => $toPath,
            )
        );

        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        return Dropbox_RequestUtil::parseResponseJson($response->body);
    }

    /**
     * Creates a folder.
     *
     * See <a href="https://www.dropbox.com/developers/core/docs#fileops-create-folder">/fileops/create_folder</a>.
     *
     * @param string $path
     *    The Dropbox path at which to create the folder (UTF-8).
     *
     * @return array|null
     *    If successful, you'll get back the
     *    <a href="https://www.dropbox.com/developers/core/docs#metadata-details">metadata object</a>
     *    for the newly-created folder.  If not successful, you'll get <code>null</code>.
     *
     * @throws Dropbox_Exception
     */
    function createFolder($path)
    {
        Dropbox_Path::checkArgNonRoot("path", $path);

        $response = $this->doPost(
            $this->apiHost,
            "1/fileops/create_folder",
            array(
                "root" => "auto",
                "path" => $path,
            ));

        if ($response->statusCode === 403) return null;
        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        return Dropbox_RequestUtil::parseResponseJson($response->body);
    }

    /**
     * Deletes a file or folder
     *
     * See <a href="https://www.dropbox.com/developers/core/docs#fileops-delete">/fileops/delete</a>.
     *
     * @param string $path
     *    The Dropbox path of the file or folder to delete (UTF-8).
     *
     * @return mixed
     *    The <a href="https://www.dropbox.com/developers/core/docs#metadata-details">metadata
     *    object</a> for the deleted file or folder.
     *
     * @throws Dropbox_Exception
     */
    function delete($path)
    {
        Dropbox_Path::checkArgNonRoot("path", $path);

        $response = $this->doPost(
            $this->apiHost,
            "1/fileops/delete",
            array(
                "root" => "auto",
                "path" => $path,
            ));

        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        return Dropbox_RequestUtil::parseResponseJson($response->body);
    }

    /**
     * Moves a file or folder to a new location.
     *
     * See <a href="https://www.dropbox.com/developers/core/docs#fileops-move">/fileops/move</a>.
     *
     * @param string $fromPath
     *    The source Dropbox path (UTF-8).
     *
     * @param string $toPath
     *    The destination Dropbox path (UTF-8).
     *
     * @return mixed
     *    The <a href="https://www.dropbox.com/developers/core/docs#metadata-details">metadata
     *    object</a> for the destination file or folder.
     *
     * @throws Dropbox_Exception
     */
    function move($fromPath, $toPath)
    {
        Dropbox_Path::checkArgNonRoot("fromPath", $fromPath);
        Dropbox_Path::checkArgNonRoot("toPath", $toPath);

        $response = $this->doPost(
            $this->apiHost,
            "1/fileops/move",
            array(
                "root" => "auto",
                "from_path" => $fromPath,
                "to_path" => $toPath,
            ));

        if ($response->statusCode !== 200) throw Dropbox_RequestUtil::unexpectedStatus($response);

        return Dropbox_RequestUtil::parseResponseJson($response->body);
    }

    /**
     * Build a URL for making a GET or PUT request.  Will add the "locale"
     * parameter.
     *
     * @param $host
     *    Either the "API" or "API content" hostname from {@link getHost()}.
     * @param $path
     *    The "path" part of the URL.  For example, "/account/info".
     * @param null $params
     *    URL parameters.  For POST requests, do not put the parameters here.
     *    Include them in the request body instead.
     *
     * @return string
     */
    function buildUrlForGetOrPut($host, $path, $params = null)
    {
        return Dropbox_RequestUtil::buildUrlForGetOrPut($this->userLocale, $host, $path, $params);
    }

    /**
     * Perform an OAuth-2-authorized GET request to the Dropbox API.  Will automatically
     * fill in "User-Agent" and "locale" as well.
     *
     * @param string $host
     *    Either the "API" or "API content" hostname from {@link getHost()}.
     * @param string $path
     *    The "path" part of the URL.  For example, "/account/info".
     * @param array|null $params
     *    GET parameters.
     * @return Dropbox_HttpResponse
     *
     * @throws Dropbox_Exception
     */
    function doGet($host, $path, $params = null)
    {
        Dropbox_Checker::argString("host", $host);
        Dropbox_Checker::argString("path", $path);
        return Dropbox_RequestUtil::doGet($this->clientIdentifier, $this->accessToken, $this->userLocale,
                                  $host, $path, $params);
    }

    /**
     * Perform an OAuth-2-authorized POST request to the Dropbox API.  Will automatically
     * fill in "User-Agent" and "locale" as well.
     *
     * @param string $host
     *    Either the "API" or "API content" hostname from {@link getHost()}.
     * @param string $path
     *    The "path" part of the URL.  For example, "/commit_chunked_upload".
     * @param array|null $params
     *    POST parameters.
     * @return Dropbox_HttpResponse
     *
     * @throws Dropbox_Exception
     */
    function doPost($host, $path, $params = null)
    {
        Dropbox_Checker::argString("host", $host);
        Dropbox_Checker::argString("path", $path);
        return Dropbox_RequestUtil::doPost($this->clientIdentifier, $this->accessToken, $this->userLocale,
                                   $host, $path, $params);
    }

    /**
     * Create a {@link Curl} object that is pre-configured with {@link getClientIdentifier()},
     * and the proper OAuth 2 "Authorization" header.
     *
     * @param string $url
     *    Generate this URL using {@link buildUrl()}.
     *
     * @return Dropbox_Curl
     */
    function mkCurl($url)
    {
        return Dropbox_RequestUtil::mkCurlWithOAuth($this->clientIdentifier, $url, $this->accessToken);
    }

    /**
     * Parses date/time strings returned by the Dropbox API.  The Dropbox API returns date/times
     * formatted like: <code>"Sat, 21 Aug 2010 22:31:20 +0000"</code>.
     *
     * @param string $apiDateTimeString
     *    A date/time string returned by the API.
     *
     * @return \DateTime
     *    A standard PHP <code>\DateTime</code> instance.
     *
     * @throws Dropbox_Exception_BadResponse
     *    Thrown if <code>$apiDateTimeString</code> isn't correctly formatted.
     */
    static function parseDateTime($apiDateTimeString)
    {
        $dt = DateTime::createFromFormat(self::$dateTimeFormat, $apiDateTimeString);
        if ($dt === false) throw new Dropbox_Exception_BadResponse(
            "Bad date/time from server: ".self::q($apiDateTimeString));
        return $dt;
    }

    private static $dateTimeFormat = "D, d M Y H:i:s T";

    /**
     * @internal
     */
    static function q($object) { return var_export($object, true); }

    /**
     * @internal
     */
    static function getField($j, $fieldName)
    {
        if (!array_key_exists($fieldName, $j)) throw new Dropbox_Exception_BadResponse(
            "missing field \"$fieldName\" in ".self::q($j));
        return $j[$fieldName];
    }

    /**
     * Given an OAuth 2 access token, returns <code>null</code> if it is well-formed (though
     * not necessarily valid).  Otherwise, returns a string describing what's wrong with it.
     *
     * @param string $s
     *
     * @return string
     */
    static function getAccessTokenError($s)
    {
        if ($s === null) return "can't be null";
        if (strlen($s) === 0) return "can't be empty";
       // if (preg_match('@[^-=_~/A-Za-z0-9\.\+]@', $s) === 1) return "contains invalid character";
        return null;
    }

    /**
     * @internal
     */
    static function checkAccessTokenArg($argName, $accessToken)
    {
        $error = self::getAccessTokenError($accessToken);
        if ($error !== null) throw new InvalidArgumentException("'$argName' invalid: $error");
    }

    /**
     * @internal
     */
    static function getClientIdentifierError($s)
    {
        if ($s === null) return "can't be null";
        if (strlen($s) === 0) return "can't be empty";
        if (preg_match('@[\x00-\x1f\x7f]@', $s) === 1) return "contains control character";
        return null;
    }

    /**
     * @internal
     */
    static function checkClientIdentifierArg($argName, $accessToken)
    {
        $error = self::getClientIdentifierError($accessToken);
        if ($error !== null) throw new InvalidArgumentException("'$argName' invalid: $error");
    }
}
