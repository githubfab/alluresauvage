jQuery(document).ready(function($) {

    var tipsySettings =  {
        gravity: 'e',
        html: true,
        trigger: 'manual',
        className: function() {
            return 'tipsy-' + $(this).data('id');
        },
        title: function() {
            activeId = $(this).data('id');
            return $(this).attr('original-title');
        }
    }

    $('.way2enjoyWhatsThis').tipsy({
        fade: true,
        gravity: 'w'
    });

    $('.way2enjoyError').tipsy({
        fade: true,
        gravity: 'e'
    });

    var data = {
            action: 'way2enjoy_request'
        },

        errorTpl = '<div class="way2enjoyErrorWrap"><a class="way2enjoyError">Failed! Hover here</a></div>',
        $btnApplyBulkAction = $("#doaction"),
        $btnApplyBulkAction2 = $("#doaction2"),
        $topBulkActionDropdown = $(".tablenav.top .bulkactions select[name='action']"),
        $bottomBulkActionDropdown = $(".tablenav.bottom .bulkactions select[name='action2']");


    var requestSuccess = function(data, textStatus, jqXHR) {
        var $button = $(this),
            $parent = $(this).closest('.way2enjoy-wrap, .buttonWrap'),
            $cell = $(this).closest("td");

        if (data.html) {
            $button.text("Image optimized");

            var type = data.type,
                originalSize = data.original_size,
                $originalSizeColumn = $(this).parent().prev("td.original_size"),
                way2enjoyedData = '';

            $parent.fadeOut("fast", function() {
                $cell
                    .find(".noSavings, .way2enjoyErrorWrap")
                    .remove();
                $cell.html(data.html);
                $cell.find('.way2enjoy-item-details')
                    .tipsy(tipsySettings);
                $originalSizeColumn.html(originalSize);
                $parent.remove();
            });

        } else if (data.error) {

            var $error = $(errorTpl).attr("title", data.error);

            $parent
                .closest("td")
                .find(".way2enjoyErrorWrap")
                .remove();


            $parent.after($error);
            $error.tipsy({
                fade: true,
                gravity: 'e'
            });

            $button
                .text("Retry request")
                .removeAttr("disabled")
                .css({
                    opacity: 1
                });
        }
    };

    var requestFail = function(jqXHR, textStatus, errorThrown) {
        $(this).removeAttr("disabled");
    };

    var requestComplete = function(jqXHR, textStatus, errorThrown) {
        $(this).removeAttr("disabled");
        $(this)
            .parent()
            .find(".way2enjoySpinner")
            .css("display", "none");
    };

    var opts = '<option value="way2enjoy-bulk-lossy">' + "Compress All" + '</option>';

    $topBulkActionDropdown.find("option:last-child").before(opts);
    $bottomBulkActionDropdown.find("option:last-child").before(opts);


    var getBulkImageData = function() {
        var $rows = $("tr[id^='post-']"),
            $row = null,
            postId = 0,
            imageDateItem = {},
            $enjoyedBtn = null,
            btnData = {},
            originalSize = '',
            rv = [];
        $rows.each(function() {
            $row = $(this);
            postId = this.id.replace(/^\D+/g, '');
            if ($row.find("input[type='checkbox'][value='" + postId + "']:checked").length) {
                $enjoyedBtn = $row.find(".way2enjoy_req");
                if ($enjoyedBtn.length) {
                    btnData = $enjoyedBtn.data();
                    originalSize = $.trim($row.find('td.original_size').text());
                    btnData.originalSize = originalSize;
                    rv.push(btnData);
                }
            }
        });
        return rv;
    };

    var bulkModalOptions = {
        zIndex: 4,
        escapeClose: true,
        clickClose: false,
        closeText: 'close',
        showClose: false
    };

    var renderBulkImageSummary = function(bulkImageData) {
        var setting = way2enjoy_settings.api_lossy;
        var nImages = bulkImageData.length;
        var header = '<p class="way2enjoyBulkHeader">Way2enjoy Bulk Image Optimization <span class="close-way2enjoy-bulk">&times;</span></p>';
        var enjoyedEmAll = '<button class="way2enjoy_req_bulk">Compress All</button>';
        var typeRadios = '<div class="radiosWrap"><p>Choose optimization mode:</p><label><input type="radio" id="way2enjoy-bulk-type-lossy" value="Lossy" name="way2enjoy-bulk-type"/>Auto</label></div>';

        var $modal = $('<div id="way2enjoy-bulk-modal" class="way2enjoy-modal"></div>')
                .html(header)
                .append(typeRadios)
                .append('<p class="the-following">The following <strong>' + nImages + '</strong> images will be optimized by Way2enjoy.com<!-- using the <strong class="bulkSetting">' + setting + '</strong> setting:--></p>')
                .appendTo("body")
                .kmodal(bulkModalOptions)
                .bind($.kmodal.BEFORE_CLOSE, function(event, modal) {

                })
                .bind($.kmodal.OPEN, function(event, modal) {

                })
                .bind($.kmodal.CLOSE, function(event, modal) {
                    $("#way2enjoy-bulk-modal").remove();
                })
                .css({
                    top: "10px",
                    marginTop: "40px"
                });

        if (setting === "lossy") {
            $("#way2enjoy-bulk-type-lossy").attr("checked", true);
        } else {
            $("#way2enjoy-bulk-type-lossless").attr("checked", true);
        }
        $bulkSettingSpan = $(".bulkSetting");
        $("input[name='way2enjoy-bulk-type']").change(function() {
            var text = this.id === "way2enjoy-bulk-type-lossy" ? "lossy" : "lossless";
            $bulkSettingSpan.text(text);
        });

        // to prevent close on clicking overlay div
        $(".jquery-modal.blocker").click(function(e) {
            return false;
        });

        // otherwise media submenu shows through modal overlay
        $("#menu-media ul.wp-submenu").css({
            "z-index": 1
        });

        var $table = $('<table id="way2enjoy-bulk"></table>'),
            $headerRow = $('<tr class="way2enjoy-bulk-header"><td>File Name</td><td style="width:120px">Original Size</td><td style="width:120px">Way2enjoy.com Stats</td></tr>');

        $table.append($headerRow);
        $.each(bulkImageData, function(index, element) {
           $table.append('<tr class="way2enjoy-item-row" data-way2enjoybulkid="' + element.id + '"><td class="way2enjoy-bulk-filename">' + element.filename + '</td><td class="way2enjoy-originalsize">' + element.originalSize + '</td><td class="way2enjoy-way2enjoyedsize"><span class="way2enjoyBulkSpinner hidden"></span></td></tr>');


        });

        $modal
            .append($table)
            .append(enjoyedEmAll);

        $(".close-way2enjoy-bulk").click(function() {
            $.kmodal.close();
        });

        if (!nImages) {
            $(".way2enjoy_req_bulk")
                .attr("disabled", true)
                .css({
                    opacity: 0.5
                });
        }
    };


    var bulkAction = function(bulkImageData) {

        $bulkTable = $("#way2enjoy-bulk");
        var jqxhr = null;

        var q = async.queue(function(task, callback) {
            var id = task.id,
                filename = task.filename;

            var $row = $bulkTable.find("tr[data-way2enjoybulkid='" + id + "']"),
                $way2enjoyedSizeColumn = $row.find(".way2enjoy-way2enjoyedsize"),
                $spinner = $way2enjoyedSizeColumn
                .find(".way2enjoyBulkSpinner")
                .css({
                    display: "inline-block"
                }),
                $savingsPercentColumn = $row.find(".way2enjoy-savingsPercent"),
                $savingsBytesColumn = $row.find(".way2enjoy-savings");

            jqxhr = $.ajax({
                url: ajax_object.ajax_url,
                data: {
                    'action': 'way2enjoy_request',
                    'id': id,
                    'type': $("input[name='way2enjoy-bulk-type']:checked").val().toLowerCase(),
                    'origin': 'bulk_optimizer'
                },
                type: "post",
                dataType: "json",
                timeout: 360000
            })
                .done(function(data, textStatus, jqXHR) {
                    if (data.success && typeof data.message === 'undefined') {
                        var type = data.type,
                            originalSize = data.original_size,
                            way2enjoyedSize = data.html,
                            savingsPercent = data.savings_percent,
                            savingsBytes = data.saved_bytes;

                        $way2enjoyedSizeColumn.html(data.html);

                        $way2enjoyedSizeColumn
                            .find('.way2enjoy-item-details')
                            .remove();

                        $savingsPercentColumn.text(savingsPercent);
                        $savingsBytesColumn.text(savingsBytes);

                        var $button = $("button[id='way2enjoyid-" + id + "']"),
                            $parent = $button.parent(),
                            $cell = $button.closest("td"),
                            $originalSizeColumn = $button.parent().prev("td.original_size");


                        $parent.fadeOut("fast", function() {
                            $cell.find(".noSavings, .way2enjoyErrorWrap").remove();
                            $cell
                                .empty()
                                .html(data.html);
                            $cell
                                .find('.way2enjoy-item-details')
                                .tipsy(tipsySettings);
                            $originalSizeColumn.html(originalSize);
                            $parent.remove();
                        });

                    } else if (data.error) {
                        if (data.error === 'This image can not be optimized any further') {
                            $way2enjoyedSizeColumn.text('No savings found.');
                        } else {

                        }
                    }
                })

            .fail(function() {

            })

            .always(function() {
                $spinner.css({
                    display: "none"
                });
                callback();
            });
        }, way2enjoy_settings.bulk_async_limit);

        q.drain = function() {
            $(".way2enjoy_req_bulk")
                .removeAttr("disabled")
                .css({
                    opacity: 1
                })
                .text("Done")
                .unbind("click")
                .click(function() {
                    $.kmodal.close();
                });
        }

        // add some items to the queue (batch-wise)
        q.push(bulkImageData, function(err) {

        });
    };


    $btnApplyBulkAction.add($btnApplyBulkAction2)
        .click(function(e) {
            if ($(this).prev("select").val() === 'way2enjoy-bulk-lossy') {
                e.preventDefault();
                var bulkImageData = getBulkImageData();
                renderBulkImageSummary(bulkImageData);

                $('.way2enjoy_req_bulk').click(function(e) {
                    e.preventDefault();
                    $(this)
                        .attr("disabled", true)
                        .css({
                            opacity: 0.5
                        });
                    bulkAction(bulkImageData);
                });
            }
        });




    var activeId = null;
    $('.way2enjoy-item-details').tipsy(tipsySettings);

    var $activePopup = null;
    $('body').on('click', '.way2enjoy-item-details', function(e) {
        //$('.tipsy[class="tipsy-' + activeId + '"]').remove();

        var id = $(this).data('id');
        $('.tipsy').remove();
        if (id == activeId) {
            activeId = null;
            $(this).text('Show details');
            return;
        }
        $('.way2enjoy-item-details').text('Show details');
        $(this).tipsy('show');
        $(this).text('Hide details');
    });

    $('body').on('click', function(e) {
        var $t = $(e.target);
        if (($t.hasClass('tipsy') || $t.closest('.tipsy').length) || $t.hasClass('way2enjoy-item-details')) {
            return;
        } else {
            activeId = null;
            $('.way2enjoy-item-details').text('Show details');
            $('.tipsy').remove();
        }
    });

    $('body').on('click', 'small.way2enjoyReset', function(e) {
        e.preventDefault();
        var $resetButton = $(this);
        var resetData = {
            action: 'way2enjoy_reset'
        };

        resetData.id = $(this).data("id");
        $row = $('#post-' + resetData.id).find('.compressed_size');

        var $spinner = $('<span class="resetSpinner"></span>');
        $resetButton.after($spinner);

        var jqxhr = $.ajax({
                url: ajax_object.ajax_url,
                data: resetData,
                type: "post",
                dataType: "json",
                timeout: 360000
            })
            .done(function(data, textStatus, jqXHR) {
                if (data.success !== 'undefined') {
                    $row
                        .hide()
                        .html(data.html)
                        .fadeIn()
                        .prev(".original_size.column-original_size")
                        .html(data.original_size);

                    $('.tipsy').remove();
                }
            });
    });

    $('body').on('click', '.way2enjoy-reset-all', function(e) {
        e.preventDefault();

        var reset = confirm('This will immediately remove all Way2enjoy metadata associated with your images. \n\nAre you sure you want to do this?');
        if (!reset) {
            return;
        }

        var $resetButton = $(this);
        $resetButton
            .text('Resetting images, pleaes wait...')
            .attr('disabled', true);
        var resetData = {
            action: 'way2enjoy_reset_all'
        };


        var $spinner = $('<span class="resetSpinner"></span>');
        $resetButton.after($spinner);

        var jqxhr = $.ajax({
                url: ajax_object.ajax_url,
                data: resetData,
                type: "post",
                dataType: "json",
                timeout: 360000
            })
            .done(function(data, textStatus, jqXHR) {
                $spinner.remove();
                $resetButton
                    .text('Your images have been reset.')
                    .removeAttr('disabled')
                    .removeClass('enabled');
            });
    });

    // $('.way2enjoyAdvancedSettings h3').on('click', function () {
    //     var $rows = $('.way2enjoy-advanced-settings');
    //     var $plusMinus = $('.way2enjoy-plus-minus');
    //     if ($rows.is(':visible')) {
    //         $rows.hide();
    //         $plusMinus
    //             .removeClass('dashicons-arrow-down')
    //             .addClass('dashicons-arrow-right');
    //     } else {
    //         $rows.show();
    //         $plusMinus
    //             .removeClass('dashicons-arrow-right')
    //             .addClass('dashicons-arrow-down');
    //     }
    // });

    $('body').on("click", ".way2enjoy_req", function(e) {
        e.preventDefault();
        var $button = $(this),
            $parent = $(this).parent();

        data.id = $(this).data("id");

        $button
            .text(wp_way2_msgs.optimizing_img)
            .attr("disabled", true)
            .css({
                opacity: 0.5
            });


        $parent
            .find(".way2enjoySpinner")
            .css("display", "inline");


        var jqxhr = $.ajax({
            url: ajax_object.ajax_url,
            data: data,
            type: "post",
            dataType: "json",
            timeout: 360000,
            context: $button
        })

        .done(requestSuccess)

        .fail(requestFail)

        .always(requestComplete);

    });
});