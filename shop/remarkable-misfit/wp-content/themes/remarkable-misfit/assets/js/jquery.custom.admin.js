/* Custom JS for the Admin (Controls the portfolio type chooser)
---------------------------------------------------------------------------*/

jQuery(document).ready(function () {
    var portfolioTypeTrigger = jQuery('#gt_portfolio_type'),
        portfolioImage = jQuery('#gt-meta-box-portfolio-image'),
        portfolioVideo = jQuery('#gt-meta-box-portfolio-video'),
        portfolioAudio = jQuery('#gt-meta-box-portfolio-audio');
    currentType = portfolioTypeTrigger.val();

    gtSwitch(currentType);

    portfolioTypeTrigger.change(function () {
        currentType = jQuery(this).val();

        gtSwitch(currentType);
    });

    function gtSwitch(currentType) {
        if (currentType === 'Audio') {
            gtHideAll(portfolioAudio);
        } else if (currentType === 'Video') {
            gtHideAll(portfolioVideo);
        } else {
            gtHideAll(portfolioImage);
        }
    }

    function gtHideAll(notThisOne) {
        portfolioImage.css('display', 'none');
        portfolioVideo.css('display', 'none');
        portfolioAudio.css('display', 'none');
        notThisOne.css('display', 'block');
    }
});