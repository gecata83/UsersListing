jQuery( document ).ready(function() {
    function handleError(e) {
        this.src='../img/rsz_not-found.png';
    }

    var loadMoreUrl = jQuery("#loadMore").data('url');

    jQuery("img").on('error', handleError);

    var reachTheEnd = false;
    var unfinishedRequest = false;

    jQuery(window).on("scroll", function() {
        var scrollHeight = jQuery(document).height();
        var scrollPosition = jQuery(window).height() + jQuery(window).scrollTop();
        if ((scrollHeight - scrollPosition) / scrollHeight === 0 && reachTheEnd == false && unfinishedRequest == false) {
            unfinishedRequest = true;
            jQuery.ajax({
                type: "GET",
                url: loadMoreUrl,
                data: {recordNumber:jQuery(".counting-records").length},
                success: function (returnData) {
                    var threeRecordPerRow = 0;
                    var divRow = jQuery('<div class="row record-per-row" />');
                    jQuery.each(returnData, function() {
                        if (returnData.endOfTheList === true) {
                            reachTheEnd = true;
                            return;
                        }

                        threeRecordPerRow += 1;
                        var avatar = this.avatar;
                        if (avatar === "0") {
                            avatar = "../img/rsz_256px-no_image_availablesvg.png";
                        }

                        var divCol = jQuery('<div class="col-md-4 counting-records" />');
                        var divPanelDefault = jQuery('<div class="panel panel-default" />');
                        var divPanelHeading = jQuery('<div class="panel-heading" />');
                        var divPanelBody = jQuery('<div class="panel-body" />');
                        var pName        = jQuery('<p />').text(this.name);
                        var pCompany     = jQuery('<p />').text(this.company);
                        var pTitle       = jQuery('<p />').text(this.title);
                        var pBio         = jQuery('<p />').text(this.bio);
                        var imgAvatar    = jQuery('<img src="' + avatar + '" class="img-circle profile-pics"/>');
                        imgAvatar.on("error", handleError);
                        divPanelHeading.append(imgAvatar);
                        divPanelDefault.append(divPanelHeading);
                        divPanelBody.append(pName);
                        divPanelBody.append(pCompany);
                        divPanelBody.append(pTitle);
                        divPanelBody.append(pBio);
                        divPanelDefault.append(divPanelBody);
                        divCol.append(divPanelDefault);
                        divRow.append(divCol);

                        if (threeRecordPerRow > 2) {
                            jQuery(".record-per-row").last().after(divRow);
                            divRow = jQuery('<div class="row record-per-row" />');
                            threeRecordPerRow = 0;
                        }
                    });

                    if (threeRecordPerRow != 0) {
                        jQuery(".record-per-row").last().after(divRow);
                        divRow = jQuery('<div class="row record-per-row" />');
                        threeRecordPerRow = 0;
                    }
                }
            }).always(function() {
                unfinishedRequest=false;
            });
        }
    });
});
