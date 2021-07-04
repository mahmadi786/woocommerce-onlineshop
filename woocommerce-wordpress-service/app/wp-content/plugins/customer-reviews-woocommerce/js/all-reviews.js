(function(){
	jQuery(function($) {
		jQuery(".ivole-comment-a, .cr-comment-a").click(function(t) {
			t.preventDefault();
			var o = jQuery(".pswp")[0];
			var pics = jQuery(this).parent().parent().find("img");
			var this_pic = jQuery(this).find("img");
			var inx = 0;
			if(pics.length > 0 && this_pic.length > 0) {
				var a = [];
				for(i=0; i<pics.length; i++) {
					a.push({
						src: pics[i].src,
						w: pics[i].naturalWidth,
						h: pics[i].naturalHeight,
						title: pics[i].alt
					});
					if(this_pic[0].src == pics[i].src) {
						inx = i;
					}
				}
				var r = {
					index: inx
				};
				new PhotoSwipe(o,PhotoSwipeUI_Default,a,r).init();
			}
		});

		//show lightbox when click on images attached to reviews
		jQuery(".ivole-video-a, .iv-comment-video-icon").click(function(t) {
			if( ! jQuery( "#iv-comment-videos-id" ).hasClass( "iv-comment-videos-modal" ) ) {
				var tt = t.target.closest("[id^='iv-comment-video-id-']");
				var iid = "#" + tt.id;
				jQuery( "#iv-comment-videos-id" ).addClass( "iv-comment-videos-modal" );
				jQuery( iid ).addClass( "iv-comment-video-modal" );
				jQuery( iid ).find( "video" ).prop( "controls", true );
				jQuery( iid ).find( ".iv-comment-video-icon" ).hide();
				jQuery( iid ).find( "video" ).get(0).play();
				jQuery( iid ).css({
					"top": "50%",
					"margin-top": function() { return -$(this).outerHeight() / 2 }
				});
				return false;
			}
		});

		//close video lightbox
		jQuery("#iv-comment-videos-id").click(function(t) {
			if( jQuery( "#iv-comment-videos-id" ).hasClass( "iv-comment-videos-modal" ) ) {
				jQuery( "#iv-comment-videos-id" ).removeClass( "iv-comment-videos-modal" );
				var vids = jQuery( "#iv-comment-videos-id" ).find("[id^='iv-comment-video-id-']");
				var i = 0;
				var iid = "";
				for( i = 0; i < vids.length; i++ ) {
					iid = "#" + vids[i].id;
					if( jQuery( iid ).hasClass( "iv-comment-video-modal" ) ) {
						jQuery( iid ).removeClass( "iv-comment-video-modal" );
						jQuery( iid ).find( "video").get(0).pause();
						jQuery( iid ).find( "video" ).prop( "controls", false );
						jQuery( iid ).find( ".iv-comment-video-icon" ).show();
						jQuery( iid ).removeAttr("style");
					}
				}
				return false;
			}
		});

		//show a div with a checkbox to send a copy of reply to CR
		jQuery("#the-comment-list").on("click", ".comment-inline", function (e) {
			var $el = $( this ), action = 'replyto';
			if ( 'undefined' !== typeof $el.data( 'action' ) ) {
				action = $el.data( 'action' );
			}
			if ( action == 'replyto' ) {
				if ( $el.hasClass( 'ivole-comment-inline' ) || $el.hasClass( 'ivole-reply-inline' ) ) {
					//jQuery('#ivole_replyto_cr_checkbox').prop('checked','checked');
					jQuery('#ivole_replyto_cr_checkbox').val('no');
					jQuery( '#ivole_replytocr' ).show();
				} else {
					jQuery( '#ivole_replytocr' ).hide();
				}
			}
			return false;
		});

		//feature or unfeature a review
		jQuery("#the-comment-list").on("click", ".cr-feature-review-link", function (e) {
			e.preventDefault();
			var review_id = jQuery(this).attr("data-reviewid");
			var cr_data = {
				"review_id": review_id,
				"cr_nonce": jQuery(this).attr("data-nonce"),
				"action": "cr-feature-review"
			};
			jQuery("#the-comment-list #comment-" + review_id + " .cr-feature-review-link").addClass("cr-feature-review-link-disabled");
			jQuery.post(ajax_object.ajax_url, cr_data, function(response) {
				jQuery("#the-comment-list #comment-" + response.review_id + " .cr-feature-review-link").removeClass("cr-feature-review-link-disabled");
				if(response.result){
					if( response.display_badge ) {
						jQuery("#the-comment-list #comment-" + response.review_id + " .cr-featured-badge-admin").removeClass("cr-featured-badge-admin-hidden");
					} else {
						jQuery("#the-comment-list #comment-" + response.review_id + " .cr-featured-badge-admin").addClass("cr-featured-badge-admin-hidden");
					}
					jQuery("#the-comment-list #comment-" + response.review_id + " .cr-feature-review-link").text(response.label);
				}
			}, "json");
		});

		//
		jQuery("#ivole_replyto_cr_checkbox").change(function() {
			if(jQuery(this).prop('checked')) {
				jQuery(this).val('yes');
			} else {
				jQuery(this).val('no');
			}
		});

		jQuery(".cr-upload-local-images-btn").on("click", function(e){
			e.preventDefault();
			var upload_files = jQuery("#review_image");
			var count_files = upload_files[0].files.length;
			if(0 < count_files) {
				var i = 0;
				var form_data = new FormData();
				form_data.append("action", "cr_upload_local_images_admin");
				form_data.append("post_id", jQuery(this).attr("data-postid"));
				form_data.append("comment_id", jQuery(this).attr("data-commentid"));
				form_data.append("cr_nonce", jQuery(this).attr("data-nonce"));
				form_data.append("count_files", jQuery(".cr-comment-images").find(".cr-comment-image").length);
				for( i = 0; i < count_files; i++ ) {
					form_data.append("cr_files_" + i, upload_files[0].files[i]);
				}
				jQuery.ajax({
					url: ajax_object.ajax_url,
					data: form_data,
					processData: false,
					contentType: false,
					dataType: "json",
					type: "POST",
					beforeSend: function() {
						jQuery(".cr-upload-local-images-status").removeClass("cr-upload-local-images-status-ok");
						jQuery(".cr-upload-local-images-status").removeClass("cr-upload-local-images-status-warning");
						jQuery(".cr-upload-local-images-status").removeClass("cr-upload-local-images-status-error");
						jQuery(".cr-upload-local-images-status").text(ajax_object.cr_uploading);
						jQuery(".cr-upload-local-images-btn").addClass("disabled cr-upload-local-images-btn-disable");
						jQuery("#review_image").addClass("disabled cr-upload-local-images-btn-disable");
					},
					xhr: function() {
						var myXhr = jQuery.ajaxSettings.xhr();
						if ( myXhr.upload ) {
							myXhr.upload.addEventListener( 'progress', function(e) {
								if ( e.lengthComputable ) {
									var perc = ( e.loaded / e.total ) * 100;
									perc = perc.toFixed(0);
									jQuery(".cr-upload-local-images-status").text(ajax_object.cr_uploading + " (" + perc + "%)");
								}
							}, false );
						}
						return myXhr;
					},
					success: function(response) {
						// update status message color
						if( 200 === response["code"] ) {
							jQuery(".cr-upload-local-images-status").addClass("cr-upload-local-images-status-ok");
						} else if( 201 === response["code"] ) {
							jQuery(".cr-upload-local-images-status").addClass("cr-upload-local-images-status-warning");
						} else {
							jQuery(".cr-upload-local-images-status").addClass("cr-upload-local-images-status-error");
						}
						// update status message text
						jQuery(".cr-upload-local-images-status").text("");
						jQuery.each(response["message"], function(index, message) {
							if( 0 < index ) {
								jQuery(".cr-upload-local-images-status").append("<br>");
							}
							jQuery(".cr-upload-local-images-status").append(message);
						});
						// reset the file upload input
						jQuery("#review_image").val("");
						jQuery(".cr-upload-local-images-btn").removeClass("disabled cr-upload-local-images-btn-disable");
						jQuery("#review_image").removeClass("disabled cr-upload-local-images-btn-disable");
						// display uploaded images (if any)
						if( "files" in response && response["files"].length > 0 ) {
							jQuery.each(response["files"], function(index, file) {
								var file_html = '<div class="cr-comment-image cr-comment-image-' + file["id"] + '">';
								file_html += '<div class="cr-comment-image-detach"><div class="cr-comment-image-detach-controls">';
								file_html += '<p>' + ajax_object.detach + '</p>';
								file_html += '<p><span class="cr-comment-image-detach-no">' + ajax_object.detach_no + '</span>';
								file_html += '<span class="cr-comment-image-detach-yes" data-attachment="' + file["id"] + '" data-nonce="' + file["nonce"] + '">' + ajax_object.detach_yes + '</span></p>';
								file_html += '<span class="cr-comment-image-detach-spinner"></span>';
								file_html += '</div><img src="' + file["url"] + '" alt="' + file["author"] + '"></div>';
								file_html += '<button class="cr-comment-image-close"><span class="dashicons dashicons-no"></span></button></div>';
								jQuery("#cr_reviews_media_meta_box .cr-comment-images .cr-comment-images-clear").before(file_html);
							});
						}
					}
				});
			}
		});

		// the 1st step to detach a picture
		jQuery(".cr-comment-images").on("click", ".cr-comment-image-close", function(e){
			e.preventDefault();
			jQuery(this).closest(".cr-comment-image").find("img").css("visibility","hidden");
			jQuery(this).closest(".cr-comment-image").find(".cr-comment-image-detach").addClass("cr-comment-image-detach-active");
			jQuery(this).closest(".cr-comment-image").find(".cr-comment-image-close").hide();
			jQuery(this).closest(".cr-comment-image").find(".cr-comment-image-detach-controls").show();
			var controlsHeight = jQuery(this).closest(".cr-comment-image").find(".cr-comment-image-detach-controls").height();
			if( jQuery(this).closest(".cr-comment-image").find(".cr-comment-image-detach").height() < controlsHeight ) {
				jQuery(this).closest(".cr-comment-image").find(".cr-comment-image-detach").height( controlsHeight );
			}
		});

		// cancel the 1st step to detach a picture
		jQuery(".cr-comment-images").on("click", ".cr-comment-image-detach .cr-comment-image-detach-no", function(e){
			e.preventDefault();
			jQuery(this).closest(".cr-comment-image").find(".cr-comment-image-detach").removeClass("cr-comment-image-detach-active");
			jQuery(this).closest(".cr-comment-image").find(".cr-comment-image-detach-controls").hide();
			jQuery(this).closest(".cr-comment-image").find("img").css("visibility","visible");
			jQuery(this).closest(".cr-comment-image").find(".cr-comment-image-detach").css("height","auto");
			jQuery(this).closest(".cr-comment-image").find(".cr-comment-image-close").show();
		});

		// confirm the 1st step to detach a picture
		jQuery(".cr-comment-images").on("click", ".cr-comment-image-detach .cr-comment-image-detach-yes", function(e){
			e.preventDefault();
			var cr_data = {
				"action": "cr_detach_images_admin",
				"cr_nonce": jQuery(this).attr("data-nonce"),
				"comment_id": jQuery(".cr-upload-local-images-btn").attr("data-commentid"),
				"attachment_id": jQuery(this).attr("data-attachment")
			};
			jQuery(this).closest(".cr-comment-image").find(".cr-comment-image-detach-controls p").hide();
			jQuery(this).closest(".cr-comment-image").find(".cr-comment-image-detach-spinner").css("display","block");
			jQuery.post(ajax_object.ajax_url, cr_data, function(response) {
				if( response["code"] ) {
					jQuery(".cr-comment-images .cr-comment-image-" + response["attachment"] ).remove();
				} else {
					jQuery(".cr-comment-image-" + response["attachment"]).find(".cr-comment-image-detach-spinner").css("display","none");
					jQuery(".cr-comment-image-" + response["attachment"]).find(".cr-comment-image-detach-controls p").show();
					jQuery(".cr-comment-image-" + response["attachment"]).find(".cr-comment-image-detach").removeClass("cr-comment-image-detach-active");
					jQuery(".cr-comment-image-" + response["attachment"]).find(".cr-comment-image-detach-controls").hide();
					jQuery(".cr-comment-image-" + response["attachment"]).find("img").css("visibility","visible");
					jQuery(".cr-comment-image-" + response["attachment"]).find(".cr-comment-image-detach").css("height","auto");
					jQuery(".cr-comment-image-" + response["attachment"]).find(".cr-comment-image-close").show();
				}
			});
		});

		jQuery( document ).ajaxSuccess(function( event, xhr, settings, data ) {
			if ( "dim-comment" == settings.action ) {
				let diff = jQuery('#' + settings.element).is('.' + settings.dimClass) ? 1 : -1;
				cr_updatePending( diff );
			} else if ( "delete-comment" == settings.action ) {
				let parsedResponse = wpAjax.parseAjaxResponse( xhr.responseXML, settings.response, settings.element ),
					targetParent = jQuery( settings.target ).parent(),
					commentRow = jQuery('#' + settings.element),
					response = true === parsedResponse ? {} : parsedResponse.responses[0],
					commentStatus = true === parsedResponse ? '' : response.supplemental.status,
					approved = commentRow.hasClass( 'approved' ) && ! commentRow.hasClass( 'unapproved' ),
					unapproved = commentRow.hasClass( 'unapproved' ),
					spammed = commentRow.hasClass( 'spam' ),
					trashed = commentRow.hasClass( 'trash' ),
					undoing = false,
					spamDiff, trashDiff, pendingDiff, approvedDiff;

				if ( targetParent.is( 'span.undo' ) ) {
					// The comment was spammed.
					if ( targetParent.hasClass( 'unspam' ) ) {
						spamDiff = -1;

						if ( 'trash' === commentStatus ) {
							trashDiff = 1;
						} else if ( '1' === commentStatus ) {
							approvedDiff = 1;
						} else if ( '0' === commentStatus ) {
							pendingDiff = 1;
						}

					// The comment was trashed.
					} else if ( targetParent.hasClass( 'untrash' ) ) {
						trashDiff = -1;

						if ( 'spam' === commentStatus ) {
							spamDiff = 1;
						} else if ( '1' === commentStatus ) {
							approvedDiff = 1;
						} else if ( '0' === commentStatus ) {
							pendingDiff = 1;
						}
					}

					undoing = true;

				// User clicked "Spam".
				} else if ( targetParent.is( 'span.spam' ) ) {
					// The comment is currently approved.
					if ( approved ) {
						approvedDiff = -1;
					// The comment is currently pending.
					} else if ( unapproved ) {
						pendingDiff = -1;
					// The comment was in the Trash.
					} else if ( trashed ) {
						trashDiff = -1;
					}
					// You can't spam an item on the Spam screen.
					spamDiff = 1;

				// User clicked "Unspam".
				} else if ( targetParent.is( 'span.unspam' ) ) {
					if ( approved ) {
						pendingDiff = 1;
					} else if ( unapproved ) {
						approvedDiff = 1;
					} else if ( trashed ) {
						// The comment was previously approved.
						if ( targetParent.hasClass( 'approve' ) ) {
							approvedDiff = 1;
						// The comment was previously pending.
						} else if ( targetParent.hasClass( 'unapprove' ) ) {
							pendingDiff = 1;
						}
					} else if ( spammed ) {
						if ( targetParent.hasClass( 'approve' ) ) {
							approvedDiff = 1;

						} else if ( targetParent.hasClass( 'unapprove' ) ) {
							pendingDiff = 1;
						}
					}
					// You can unspam an item on the Spam screen.
					spamDiff = -1;

				// User clicked "Trash".
				} else if ( targetParent.is( 'span.trash' ) ) {
					if ( approved ) {
						approvedDiff = -1;
					} else if ( unapproved ) {
						pendingDiff = -1;
					// The comment was in the spam queue.
					} else if ( spammed ) {
						spamDiff = -1;
					}
					// You can't trash an item on the Trash screen.
					trashDiff = 1;

				// User clicked "Restore".
				} else if ( targetParent.is( 'span.untrash' ) ) {
					if ( approved ) {
						pendingDiff = 1;
					} else if ( unapproved ) {
						approvedDiff = 1;
					} else if ( trashed ) {
						if ( targetParent.hasClass( 'approve' ) ) {
							approvedDiff = 1;
						} else if ( targetParent.hasClass( 'unapprove' ) ) {
							pendingDiff = 1;
						}
					}
					// You can't go from Trash to Spam.
					// You can untrash on the Trash screen.
					trashDiff = -1;

				// User clicked "Approve".
				} else if ( targetParent.is( 'span.approve:not(.unspam):not(.untrash)' ) ) {
					approvedDiff = 1;
					pendingDiff = -1;

				// User clicked "Unapprove".
				} else if ( targetParent.is( 'span.unapprove:not(.unspam):not(.untrash)' ) ) {
					approvedDiff = -1;
					pendingDiff = 1;

				// User clicked "Delete Permanently".
				} else if ( targetParent.is( 'span.delete' ) ) {
					if ( spammed ) {
						spamDiff = -1;
					} else if ( trashed ) {
						trashDiff = -1;
					}
				}

				if ( pendingDiff ) {
					cr_updatePending( pendingDiff );
				}
			// Reviews - Approve and Reply
			} else if ( settings.data.indexOf( "ivole-replyto-comment" ) !== -1 && settings.data.indexOf( "approve_parent=1" ) !== -1 ) {
				cr_updatePending( -1 );
			// Q&A - Approve and Reply
			} else if ( settings.data.indexOf( "cr-replyto-qna" ) !== -1 && settings.data.indexOf( "approve_parent=1" ) !== -1 ) {
				cr_updatePending( -1 );
			}
		});

	});

	function cr_updatePending( diff ) {
		let bubbleClass = jQuery(".cr_qna").length ? "pending-count-qna" : "pending-count-rev";
		jQuery( "span." + bubbleClass ).each(function() {
			var a = jQuery(this), n = cr_getCount(a) + diff;
			if ( n < 1 )
				n = 0;
			a.closest('.awaiting-mod')[ 0 === n ? 'addClass' : 'removeClass' ]('count-0');
			cr_updateCount( a, n );
		});
	};

	function cr_updateCount(el, n) {
		var n1 = '';
		if ( isNaN(n) ) {
			return;
		}
		n = n < 1 ? '0' : n.toString();
		if ( n.length > 3 ) {
			while ( n.length > 3 ) {
				n1 = thousandsSeparator + n.substr(n.length - 3) + n1;
				n = n.substr(0, n.length - 3);
			}
			n = n + n1;
		}
		el.html(n);
	};

	function cr_getCount(el) {
		var n = parseInt( el.html().replace(/[^0-9]+/g, ''), 10 );
		if ( isNaN(n) ) {
			return 0;
		}
		return n;
	};
}());
