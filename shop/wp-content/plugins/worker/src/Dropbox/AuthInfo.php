<?php

/**
 * This class contains methods to load an AppInfo and AccessToken from a JSON file.
 * This can help simplify simple scripts (such as the example programs that come with the
 * SDK) but is probably not useful in typical Dropbox API apps.
 *
 */
final class Dropbox_AuthInfo
{
    /**
     * Loads a JSON file containing authorization information for your app. 'php authorize.php'
     * in the examples directory for details about what this file should look like.
     *
     * @param string $path
     *    Path to a JSON file
     * @return array
     *    A <code>list(string $accessToken, Host $host)</code>.
     *
     * @throws Dropbox_AuthInfoLoadException
     */
    static function loadFromJsonFile($path)
    {
        if (!file_exists($path)) {
            throw new Dropbox_AuthInfoLoadException("File doesn't exist: \"$path\"");
        }

        $str = file_get_contents($path);
        $jsonArr = json_decode($str, TRUE);

        if (is_null($jsonArr)) {
            throw new Dropbox_AuthInfoLoadException("JSON parse error: \"$path\"");
        }

        return self::loadFromJson($jsonArr);
    }

    /**
     * Parses a JSON object to build an AuthInfo object.  If you would like to load this from a file,
     * please use the @see loadFromJsonFile method.
     *
     * @param array $jsonArr
     *    A parsed JSON object, typcally the result of json_decode(..., TRUE).
     * @return array
     *    A <code>list(string $accessToken, Host $host)</code>.
     *
     * @throws Dropbox_AuthInfoLoadException
     */
    private static function loadFromJson($jsonArr)
    {
        if (!is_array($jsonArr)) {
            throw new Dropbox_AuthInfoLoadException("Expecting JSON object, found something else");
        }

        // Check access_token
        if (!array_key_exists('access_token', $jsonArr)) {
            throw new Dropbox_AuthInfoLoadException("Missing field \"access_token\"");
        }

        $accessToken = $jsonArr['access_token'];
        if (!is_string($accessToken)) {
            throw new Dropbox_AuthInfoLoadException("Expecting field \"access_token\" to be a string");
        }

        // Check for the optional 'host' field
        if (!array_key_exists('host', $jsonArr)) {
            $host = null;
        }
        else {
            $baseHost = $jsonArr["host"];
            if (!is_string($baseHost)) {
                throw new Dropbox_AuthInfoLoadException("Optional field \"host\" must be a string");
            }

            $api = "api-$baseHost";
            $content = "api-content-$baseHost";
            $web = "meta-$baseHost";

            $host = new Dropbox_Host($api, $content, $web);
        }

        return array($accessToken, $host);
    }
}
