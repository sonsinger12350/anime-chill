var $ = jQuery.noConflict(),
	HaLim = {
		Init: function () {
			HaLim.AjaxSearch(), HaLim.Actions(), HaLim.Bookmark(), HaLim.ShowTrailer(), HaLim.Rating(), HaLim.GetEpsNav(),
				HaLim.isAdult(), HaLim.ProfilesBookmark(), HaLim.ShowTimes()
		},
		GetPostByWidgetType: function (a, e, t, o, i) {
			$.ajax({
				type: "POST",
				url: halim.ajax_url,
				data: {
					action: "halim_get_post_by_categories_widget",
					showpost: t,
					type: a,
					layout: e,
					sortby: o
				},
				beforeSend: function () {
					$(".halim-" + a + "-widget-" + i + " .halim-ajax-popular-post-loading").removeClass("hidden")
				},
				success: function (e) {
					$("#ajax-" + a + "-widget-" + i).html(e), $(".halim-" + a + "-widget-" + i +
						" .halim-ajax-popular-post-loading").addClass("hidden"), $(
							'.icon_overlay[data-toggle="halim-popover"]').popover({
								placement: "top",
								container: "body"
							})
				},
				error: function (e) {
					$("#ajax-" + a + "-widget-" + i).html("Apparently, there are no posts to show!"), $(".halim-" + a +
						"-widget-" + i + " .halim-ajax-popular-post-loading").addClass("hidden")
				}
			})
		},
		Actions: function () {
			if ($('.icon_overlay[data-toggle="halim-popover"]').popover({
				container: "body",
				trigger: "hover"
			}), $('.episode-pagination a[data-toggle="tab"]').on("shown.bs.tab", (function (a) {
				var e = $(a.target).data("server");
				$('[role="tabpanel"].active .eid-' + e + "-1").click()
			})), $("body.halimmovies.single-post").length && ($.ajax({
				type: "POST",
				url: halim_cfg.ajax_url,
				dataType: "json",
				data: {
					action: "halim_set_post_view_count",
					post_id: halim_cfg.post_id
				},
				success: function (a) {
					$(".view-count span").html(a.view)
				}
			}), $(".show-more").click((function () {
				if ($(this).parent().parent().find(".item-content").toggleClass("toggled"), $(this).parent().find(
					".item-content-gradient").toggleClass("hidden"), 1 == $(this).data("single")) {
					var a = $(this).text() == $(this).data("showmore") ? $(this).data("showless") : $(this).data(
						"showmore");
					$(this).text(a)
				} else {
					var e = "hl-angle-down" == $(this).data("icon") ? "hl-angle-up" : "hl-angle-down";
					$(this).toggleClass(e).toggleClass("hl-angle-down")
				}
			})), HaLim.NextPrevEpisode(), HaLim.EpisodeNavigation(), HaLim.EpisodeItemSearch()), $(
				".clickable, .letter-item").click((function () {
					var a = $(this).data("href");
					window.location.href = a
				})), $(".halim_ajax_get_post").on("click", (function () {
					var a = $(this).data("widgetid");
					$(".halim_ajax_get_post").removeClass("active"), $(this).addClass("active"), $.ajax({
						url: halim.ajax_url,
						type: "POST",
						data: {
							action: "halim_ajax_get_post_by_cat",
							cat_id: $(this).data("catid"),
							showpost: $(this).data("showpost"),
							layout: $(this).data("layout")
						},
						beforeSend: function () {
							$("#" + a + "-ajax-box .halim-ajax-get-post-loading").removeClass("hidden")
						},
						success: function (e) {
							$("#" + a + "-ajax-box").html(e), $("#" + a + "-ajax-box .halim-ajax-get-post-loading")
								.addClass("hidden"), $('.icon_overlay[data-toggle="halim-popover"]').popover({
									placement: "top",
									container: "body"
								})
						}
					})
				})), $(".ajax-tab").click((function () {
					$.ajax({
						type: "POST",
						url: halim.ajax_url,
						data: {
							action: "halim_get_popular_post",
							showpost: $(this).data("showpost"),
							show_view_count: $(this).data("show_view_count"),
							rand: $(this).data("rand"),
							type: $(this).data("type")
						},
						beforeSend: function () {
							$(".halim_tab_popular_videos-widget .halim-ajax-popular-post-loading").removeClass("hidden")
						},
						success: function (a) {
							$("#halim-ajax-popular-post").html(a), $(
								".halim_tab_popular_videos-widget .halim-ajax-popular-post-loading").addClass("hidden")
						},
						error: function (a) {
							$("#halim-ajax-popular-post").html("Apparently, there are no posts to show!")
						}
					})
				})), $(".ajax-vertical-widget").click((function () {
					var a = $(this).data("type"),
						e = $(this).data("showpost"),
						t = $(this).data("sortby");
					$.ajax({
						type: "POST",
						url: halim.ajax_url,
						data: {
							action: "halim_get_post_by_vertical_widget",
							showpost: e,
							sortby: t,
							show_view_count: $(this).data("show-view-count"),
							rand: $(this).data("rand"),
							type: a
						},
						beforeSend: function () {
							$("." + a + " .halim-ajax-popular-post-loading").removeClass("hidden")
						},
						success: function (e) {
							$("#ajax-vertical-widget-" + a).html(e), $("." + a + " .halim-ajax-popular-post-loading")
								.addClass("hidden")
						},
						error: function (e) {
							$("#ajax-vertical-widget-" + a).html("Apparently, there are no posts to show!"), $("." + a +
								" .halim-ajax-popular-post-loading").addClass("hidden")
						}
					})
				})), $(".ajax-category-widget").click((function () {
					var a = $(this).data("type"),
						e = $(this).data("showpost"),
						t = $(this).data("layout"),
						o = $(this).data("category"),
						i = $(this).data("widget-id");
					$.ajax({
						type: "POST",
						url: halim.ajax_url,
						data: {
							action: "halim_get_post_by_categories_widget",
							showpost: e,
							type: a,
							layout: t,
							category: o
						},
						beforeSend: function () {
							$(".halim-category-widget-" + i + " .halim-ajax-popular-post-loading").removeClass("hidden")
						},
						success: function (a) {
							$("#ajax-category-widget-" + i).html(a), $(".halim-category-widget-" + i +
								" .halim-ajax-popular-post-loading").addClass("hidden"), $(
									'.icon_overlay[data-toggle="halim-popover"]').popover({
										placement: "top",
										container: "body"
									})
						},
						error: function (a) {
							$("#ajax-category-widget-" + i).html("Apparently, there are no posts to show!"), $(
								".halim-category-widget-" + i + " .halim-ajax-popular-post-loading").addClass("hidden")
						}
					})
				})), window.matchMedia("(max-width: 767px)").matches || is_Mobile() || iOS()) {
				if ($("#search-form-pc").prependTo("#mobile-search-form"), $("#pc-user-login").prependTo(
					"#mobile-user-login"), $(".ui-autocomplete").remove(), $(".halim-search-form").removeClass("hidden-xs"), $(
						'<ul class="ui-autocomplete ajax-results hidden"></ul>').insertAfter("#mobile-search-form"), $(
							".navbar-container").hasClass("header-3")) {
					var a = $(".desktop-mode").html();
					$(".desktop-mode").html(""), $(a).insertAfter(".navbar-brand")
				}
				$("body").hasClass("logged-in") && $("#pc-user-logged-in").prependTo("#mobile-user-login")
			}
			$(document).on("click", ".toggle-pagination-pc", (function (a) {
				$("#letter-filter").slideToggle(), $(".navbar-container").hasClass("navbar-fixed-top") && $(
					"html, body").animate({
						scrollTop: $("#letter-filter").offset().top - 100
					}, 2e3), $(this).toggleClass("active"), a.preventDefault()
			})), is_Mobile() && $("#collapseEps").on("shown.bs.collapse", (function () {
				$("html, body").animate({
					scrollTop: $("#halim-list-server").offset().top - 100
				}, 2e3)
			}));
			var e = 64;
			$(window).scroll((function (a) {
				var t = $(this).scrollTop(),
					o = $("#header").height();
				t > ($("body.single-post").length ? 600 : 64) ? $(".navbar-container").addClass("navbar-fixed-top") : $(
					".navbar-container").removeClass("navbar-fixed-top"), t >= o && (t > e ? $(".navbar-container")
						.addClass("heads-up") : $(".navbar-container").removeClass("heads-up"), e = t), t > 600 ? $(
							"#easy-top").fadeIn(400) : $("#easy-top").fadeOut(100)
			})), $("#easy-top").click((function () {
				$("html, body").animate({
					scrollTop: 0
				}, {
					duration: 1200
				})
			})), $('[data-toggle="tooltip"]').tooltip(), is_Mobile() || 1 != $(".halim-navbar").data("dropdown-hover") ||
				$("ul.nav li.dropdown").hover((function () {
					$(this).find(".dropdown-menu").stop(!0, !0).delay(150).fadeIn(100)
				}), (function () {
					$(this).find(".dropdown-menu").stop(!0, !0).delay(150).fadeOut(100)
				})), $('.halim-search-formX input[name="s"]').on("input", (function () {
					$(this).val().match(/[^a-zA-Z]/g) && $(this).val($(this).val().replace(
						/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a").replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e").replace(
							/ì|í|ị|ỉ|ĩ/g, "i").replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o").replace(
								/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u").replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y").replace(/đ/g, "d")), "" != $(this).val() ?
							$(".hl-spin4").removeClass("hidden") : $(".hl-spin4").addClass("hidden")
				})), setTimeout((() => {
					console.log(`%c HaLimMovie %c ${halim.theme_version} %c https://halimthemes.com`,
						"color: #fff; background: #5f5f5f", "color: #fff; background: #4bc729", "");
					var a = "color:rgb(255, 139, 0);font-weight:bold;",
						e = "color:#2196F3;font-weight:bold;";
					console.log(
						"\n%cXX    XX       XX       XX      XX  XXX     XXX%c\n%cXX    XX      XXXX      XX      XX  XXXX   XXXX%c\n%cXX    XX     XX  XX     XX      XX  XX XX XX XX%c\n%cXXXXXXXX    XXXXXXXX    XX      XX  XX  XXX  XX%c\n%cXX    XX   XX      XX   XX      XX  XX       XX%c\n%cXX    XX  XX        XX  XX      XX  XX       XX%c\n%cXX    XX XX          XX XXXXXXX XX  XX       XX%c\n",
						e, e, e, e, e, e, e, e, a, e, a, e, a, e), console.log(
							"\n %c Theme developed by HaLimThemes.Com %c https://halimthemes.com ",
							"color: #FFF; background: #222d38; padding:5px 0;background-size: 300% 100%;background-image: linear-gradient(to right, #25aae1, #024fd6, #04befe, #3f86ed);",
							"color: #FFF; border: 1px solid #8f8f8f;padding:4px 0;")
				}), 100), $("#search-form").on("shown.bs.collapse", (function () {
					$("#search").focus()
				})), $("#expand-filter-movie").click((function () {
					$(this).toggleClass("active"), $("#filter-movie").toggleClass("in"), $("#expand-filter-movie i")
						.toggleClass("hl-up-open-1"), $("#filter-movie").html(filterMovieHTML), $(".navbar-container")
							.hasClass("navbar-fixed-top") && $("html, body").animate({
								scrollTop: $("#filter-movie").offset().top - 100
							}, 2e3)
				})), 1 == halim.sync && (is_Mobile() || document.addEventListener("keydown", (function (a) {
					console.log(a.which), 123 == a.which && (a.preventDefault(), window.location.href = halim
						.db_redirect_url)
				})))
		},
		AjaxSearch: function () {
			if (1 == halim.ajax_live_search) {
				$("#search").blur((function (a) {
					setTimeout((function () {
						$(".ajax-results").fadeOut()
					}), 300)
				}));
				var a = null;
				$("#search").keyup((function () {
					clearTimeout(a);
					var e = $(this);
					a = setTimeout((function () {
						$.ajax({
							type: "POST",
							url: halim.ajax_url,
							dataType: "html",
							data: {
								action: "halim_ajax_live_search",
								search: e.val()
							},
							beforeSend: function () {
								$(".hl-spin4").removeClass("hidden")
							},
							success: function (a) {
								$(".ajax-results").removeClass("hidden"), $(".ajax-results").html(a).show(), $(
									".hl-spin4").addClass("hidden")
							}
						})
					}), 200)
				}))
			}
		},
		ShowTimes: function () {
			$(".halim-showtimes-block li.weekday").click((function () {
				var a = $(this).data("id"),
					t = $(this).data("term_id"),
					o = $(this).data("term_slug"),
					i = $(this).data("layout");
				e = $(this).data("type"), $(".halim-showtimes-block li.weekday").removeClass("active"), $(
					".halim-showtimes-widget .halim-ajax-popular-post-loading").removeClass("hidden"), $(this).addClass(
						"active"), $.ajax({
							type: "POST",
							url: halim.ajax_url,
							dataType: "html",
							data: {
								action: "halim_showtimes",
								weekday: a,
								term_id: t,
								term_slug: o,
								layout: i,
								type: e
							},
							success: a => {
								$("#ajax-showtimes-widget").html(a), $(
									".halim-showtimes-widget .halim-ajax-popular-post-loading").addClass("hidden")
							}
						})
			})), $(document).on("click", ".showtimes-term-children li a.time", (function () {
				var a = $(this).data("id"),
					e = $(this).data("parent-term-id"),
					t = $(this).data("widget-id"),
					o = $(this).data("layout"),
					i = $(this).data("type");
				"widget" == i ? $(".halim-showtimes-widget .halim-ajax-popular-post-loading").removeClass("hidden") : $(
					".halim-ajax-popular-post-loading-" + t).removeClass("hidden"), $.ajax({
						type: "POST",
						url: halim.ajax_url,
						dataType: "html",
						data: {
							action: "halim_showtimes_children",
							type: i,
							term_id: a,
							layout: o,
							widget_id: t,
							parent_term_id: e
						},
						success: a => {
							"widget" == i ? ($("#ajax-showtimes-widget").html(a), $(
								".halim-showtimes-widget .halim-ajax-popular-post-loading").addClass("hidden")) : ($(
									"#ajax-showtimes-widget-" + t).html(a), $(".halim-ajax-popular-post-loading-" + t)
										.addClass("hidden"))
						}
					})
			}))
		},
		Bookmark: function () {
			if ("undefined" != typeof Storage) {
				var a = 0,
					e = {};
				if (void 0 !== localStorage.halim_bookmark && "{}" !== localStorage.halim_bookmark) {
					e = JSON.parse(localStorage.halim_bookmark);
					a = Object.keys(e).length, $("#get-bookmark span.count, .get-bookmark-on-mobile span.count").text(a)
				}
				$(".navbar-toggle-bookmark").click((function () {
					if ($(this).removeClass("navbar-toggle-bookmark"), $("body").hasClass("modal-open") || $(
						".modal-html").html(
							'<div class="modal fade" id="bookmark-modal" tabindex="-1" role="dialog" aria-labelledby="bookmark-modal"><div class="modal-dialog modal-md"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">×</button><h4 class="modal-title adult-content-title"><i class="hl-heart-empty"></i> Bookmark List</h4></div><div class="modal-body panel-body"><ul class="halim-bookmark-lists" id="list-fav"></ul></div><div class="modal-footer"><span style="float:left;margin-top: 5px;">Total: ' +
							a +
							' item</span><button type="button" class="btn btn-danger remove-all-bookmark"><i class="hl-cancel"></i> Remove All</button><button type="button" class="btn btn-default" data-dismiss="modal"><i class="hl-cancel"></i> Close</button></div></div></div></div>'
						), Object.keys(e).length > 0) {
						var t = "";
						$.each(e, (function (a, e) {
							t += '<li class="bookmark-list"><a href="' + e.link + '"><img src="' + e.thumb + '" alt="' +
								e.title + '"><span class="bookmark-title">' + e.title +
								'</span><span class="bookmark-date">' + e.date +
								'</span></a><span class="remove-bookmark box-shadow" data-post_id="' + a +
								'">x</span></li>'
						})), $("#list-fav").html(t)
					} else $("#list-fav").html('<li style="text-align:center;color:#ccc;">Nothing found!</li>')
				})), $(".navbar-toggle-bookmark").on("hidden.bs.modal", (function () {
					$("#bookmark-modal").modal("hide")
				})), $("body.single-post").length && e[halim_cfg.post_id] && ($("#bookmark, .halim-bookmark-post")
					.removeClass("bookmark-img-animation").addClass("bookmarked"), $("#bookmark, .halim-bookmark-post").attr(
						"data-original-title", "Remove from favorites")), $("#bookmark, .halim-bookmark-post").click((
							function () {
								if ($(this).hasClass("bookmarked")) $(this).removeClass("bookmarked").addClass(
									"bookmark-img-animation"), $(this).tooltip().attr("data-original-title", "Add to favorites")
										.tooltip("show"), delete e[$(this).data("post_id")], localStorage.halim_bookmark = JSON.stringify(
											e), 0 == Object.keys(e).length && $("#list-fav").html(
												'<li style="text-align:center;color:#ccc;">Nothing found!</li>'), a = Object.keys(e).length, $(
													"#get-bookmark span.count, .get-bookmark-on-mobile span.count").text(a);
								else {
									$(this).removeClass("bookmark-img-animation").addClass("bookmarked"), $(this).tooltip().attr(
										"data-original-title", "Remove from favorites").tooltip("show");
									var t = $(this).data("post_id");
									null == e[t] && (e[t] = {
										link: $(this).data("href"),
										thumb: $(this).data("thumbnail"),
										title: $(this).data("title"),
										date: $(this).data("date")
									}, localStorage.halim_bookmark = JSON.stringify(e), a = Object.keys(e).length, $(
										"#get-bookmark span.count, .get-bookmark-on-mobile span.count").text(a))
								}
								return !1
							})), $(document).on("click", ".bookmark-list .remove-bookmark", (function () {
								delete e[$(this).data("post_id")], localStorage.halim_bookmark = JSON.stringify(e), $(this).parent()
									.remove(), 0 == Object.keys(e).length && $("#list-fav").html(
										'<li style="text-align:center;color:#ccc;">Nothing found!</li>'), a = Object.keys(e).length, $(
											"#get-bookmark span.count, .get-bookmark-on-mobile span.count").text(a)
							})), $(document).on("click", ".remove-all-bookmark", (function () {
								confirm("Are you sure you want to delete all item?") && (localStorage.removeItem("halim_bookmark"), $(
									"#list-fav").html(
										'<li style="text-align:center;color:#ccc;">Your bookmark has been deleted!</li>'), $(".count")
											.text("0"), console.log("localStorage has been deleted!"))
							}))
			}
		},
		ProfilesBookmark: function () {
			if ("undefined" != typeof Storage) {
				var a = 0,
					e = {};
				if (void 0 !== localStorage.halim_bookmark && "{}" !== localStorage.halim_bookmark) {
					e = JSON.parse(localStorage.halim_bookmark);
					a = Object.keys(e).length, $("span.count i").text(a)
				}
				Object.keys(e).length > 0 ? $.each(e, (function (a, e) {
					$("#bookmarkList").append('<li class="bookmark-list profile-bm"><a href="' + e.link + '"><img src="' +
						e.thumb + '" alt="' + e.title + '"><span class="bookmark-title">' + e.title +
						'</span><span class="bookmark-date">' + e.date +
						'</span></a><span class="remove-bookmark box-shadow" id="' + a + '">x</span></li>')
				})) : $("#list-fav").html('<li style="text-align:center;color:#ccc;">Nothing found!</li>'), $(document).on(
					"click", "#bookmarkList .bookmark-list .remove-bookmark", (function () {
						delete e[$(this).attr("id")], localStorage.halim_bookmark = JSON.stringify(e), $(this).parent()
							.remove(), 0 == Object.keys(e).length && $("#list-fav").html(
								'<li style="text-align:center;color:#ccc;">Nothing found!</li>'), a = Object.keys(e).length, $(
									"#get-bookmark span.count, .get-bookmark-on-mobile span.count i").text(a)
					}))
			}
		},
		ShowTrailer: function () {
			$("#show-trailer").click((function () {
				"" != $(this).data("url") ? ($("body").append(
					'<div class="modal fade" id="trailer" tabindex="-1" role="dialog" aria-labelledby="mobileModalLabel"><div class="modal-dialog modal-lg" style="position:relative;background: #fff;border: 1px solid #eee;padding: 10px;text-align: center;border-radius: 5px;"><div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="' +
					$(this).data("url") +
					'" frameborder="0" allowfullscreen></iframe></div><div class="modal-footer" style="text-align:center;"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></div></div></div>'
				), $("#trailer").modal("show")) : ($("body").append(
					'<div class="modal fade" id="trailer" tabindex="-1" role="dialog" aria-labelledby="mobileModalLabel" aria-hidden="true"><div class="modal-dialog modal-sm" style="position:relative;background: #fff;border: 1px solid #eee;padding: 10px;text-align: center;border-radius: 5px;"><p style="margin:0;">Trailer Not Found!</p></div></div>'
				), $("#trailer").modal("show")), $("#trailer").on("hidden.bs.modal", (function (a) {
					$("#trailer").remove()
				}))
			}))
		},
		isAdult: function () {
			if ("undefined" != typeof halim_cfg) {
				var a =
					'<div id="is_adultModal" class="modal fade" role="dialog">          <div class="modal-dialog modal-md">            <div class="modal-content">                <div class="modal-header">                    <button type="button" class="close" data-dismiss="modal">×</button>                    <h4 class="modal-title adult-content-title">' +
					halim_cfg.adult_title +
					'</h4>                </div>                <div class="modal-body panel-body adult-content-info">                    ' +
					halim_cfg.adult_content +
					'                </div>               <div class="modal-footer">                   <div class="checkbox pull-left">                        <label><input class="modal-check" name="modal-check" type="checkbox"> ' +
					halim_cfg.show_only_once +
					'</label>                    </div>                    <button type="button" class="btn btn-danger"><a href="/" style="color: white;">' +
					halim_cfg.exit_btn +
					'</a></button>                    <button type="button" class="btn btn-primary" data-dismiss="modal">' +
					halim_cfg.is_18plus + "</button>              </div>            </div>          </div>        </div>";
				1 == halim_cfg.is_adult && ($("body").append(a), "undefined" != typeof Storage && ("dont-show" !==
					sessionStorage.getItem("is_adult") && (sessionStorage.setItem("is_adult", "show"), setTimeout((
						function () {
							$("#is_adultModal").modal("show")
						}), 1e3)), $(".modal-check").change((function () {
							sessionStorage.setItem("is_adult", "dont-show")
						}))))
			}
			return !1
		},
		ReportError: function (a, e) {
			$.ajax({
				type: "POST",
				url: ajax_player.url,
				data: {
					action: "halim_report",
					id_post: halim_cfg.post_id,
					server: a,
					episode: e,
					post_name: $("h1.entry-title").text() + " server " + a,
					halim_error_url: encodeURI(window.location),
					content: "Auto report",
					name: "BOT"
				},
				success: function (a) {
					console.log("Auto report successfuly!")
				}
			})
		},
		LoadEpList: function (a, e, t, o, i, l) {
			$.ajax({
				type: "POST",
				url: halim.ajax_url,
				data: {
					action: "halim_episode_pagination",
					postid: a,
					server: e,
					cur_sv: t,
					eps_nav: o,
					episode: i,
					eps_link: l
				},
				beforeSend: function () {
					$(".list-episode-ajax-" + e).html('<div class="text-center"><img src="' + halim_cfg.loading_img +
						'" /></div>')
				},
				success: function (a) {
					$(".list-episode-ajax-" + e).html(a), HaLim.NextPrevEpisode()
				}
			})
		},
		GetEpsNav: function () {
			if ($("body.single-post").length && ("true" == halim_cfg.paging_episode || "show_paging_eps" == halim_cfg
				.episode_display)) {
				var a = halim_cfg.post_id,
					e = halim_cfg.episode_slug,
					t = halim_cfg.server;
				if ($("body").on("click", ".eps-page-nav", (function () {
					var o = $(this).data("list-eps"),
						i = $(this).data("server"),
						l = $(this).data("link");
					$(".eps-page-nav").removeClass("active"), $(this).addClass("active"), HaLim.LoadEpList(a, i, t, o, e,
						l)
				})), $("body.single-post").length) {
					var o = $(".eps-page-nav.active"),
						i = o.data("list-eps"),
						l = o.data("server"),
						s = o.data("link");
					console.log(o), HaLim.LoadEpList(a, l, t, i, e, s)
				}
			}
		},
		NextPrevEpisode: function () {
			$(".halim-next-episode").click((function () {
				var a = $(".halim-episode-item.active");
				window.location.href = a.next().data("href")
			})), $(".halim-prev-episode").click((function () {
				var a = $(".halim-episode-item.active");
				window.location.href = a.prev().data("href")
			}))
		},
		ChangeStyle: function () {
			if (1 == halim.light_mode_btn && ($(
				'<div class="halim-light-mode-button"><label for=\'halim-light-mode\'><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="nightIcon" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve"><path d="M96.76,66.458c-0.853-0.852-2.15-1.064-3.23-0.534c-6.063,2.991-12.858,4.571-19.655,4.571  C62.022,70.495,50.88,65.88,42.5,57.5C29.043,44.043,25.658,23.536,34.076,6.47c0.532-1.08,0.318-2.379-0.534-3.23  c-0.851-0.852-2.15-1.064-3.23-0.534c-4.918,2.427-9.375,5.619-13.246,9.491c-9.447,9.447-14.65,22.008-14.65,35.369  c0,13.36,5.203,25.921,14.65,35.368s22.008,14.65,35.368,14.65c13.361,0,25.921-5.203,35.369-14.65  c3.872-3.871,7.064-8.328,9.491-13.246C97.826,68.608,97.611,67.309,96.76,66.458z" /></svg></label><input class=\'toggle\' id=\'halim-light-mode\' type=\'checkbox\'><label class=\'toggle-button\' for=\'halim-light-mode\'></label><label for=\'halim-light-mode\'><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="dayIcon" x="0px" y="0px" viewBox="0 0 35 35" style="enable-background:new 0 0 35 35;" xml:space="preserve"><g id="Sun"><g><path style="fill-rule:evenodd;clip-rule:evenodd;" d="M6,17.5C6,16.672,5.328,16,4.5,16h-3C0.672,16,0,16.672,0,17.5    S0.672,19,1.5,19h3C5.328,19,6,18.328,6,17.5z M7.5,26c-0.414,0-0.789,0.168-1.061,0.439l-2,2C4.168,28.711,4,29.086,4,29.5    C4,30.328,4.671,31,5.5,31c0.414,0,0.789-0.168,1.06-0.44l2-2C8.832,28.289,9,27.914,9,27.5C9,26.672,8.329,26,7.5,26z M17.5,6    C18.329,6,19,5.328,19,4.5v-3C19,0.672,18.329,0,17.5,0S16,0.672,16,1.5v3C16,5.328,16.671,6,17.5,6z M27.5,9    c0.414,0,0.789-0.168,1.06-0.439l2-2C30.832,6.289,31,5.914,31,5.5C31,4.672,30.329,4,29.5,4c-0.414,0-0.789,0.168-1.061,0.44    l-2,2C26.168,6.711,26,7.086,26,7.5C26,8.328,26.671,9,27.5,9z M6.439,8.561C6.711,8.832,7.086,9,7.5,9C8.328,9,9,8.328,9,7.5    c0-0.414-0.168-0.789-0.439-1.061l-2-2C6.289,4.168,5.914,4,5.5,4C4.672,4,4,4.672,4,5.5c0,0.414,0.168,0.789,0.439,1.06    L6.439,8.561z M33.5,16h-3c-0.828,0-1.5,0.672-1.5,1.5s0.672,1.5,1.5,1.5h3c0.828,0,1.5-0.672,1.5-1.5S34.328,16,33.5,16z     M28.561,26.439C28.289,26.168,27.914,26,27.5,26c-0.828,0-1.5,0.672-1.5,1.5c0,0.414,0.168,0.789,0.439,1.06l2,2    C28.711,30.832,29.086,31,29.5,31c0.828,0,1.5-0.672,1.5-1.5c0-0.414-0.168-0.789-0.439-1.061L28.561,26.439z M17.5,29    c-0.829,0-1.5,0.672-1.5,1.5v3c0,0.828,0.671,1.5,1.5,1.5s1.5-0.672,1.5-1.5v-3C19,29.672,18.329,29,17.5,29z M17.5,7    C11.71,7,7,11.71,7,17.5S11.71,28,17.5,28S28,23.29,28,17.5S23.29,7,17.5,7z M17.5,25c-4.136,0-7.5-3.364-7.5-7.5    c0-4.136,3.364-7.5,7.5-7.5c4.136,0,7.5,3.364,7.5,7.5C25,21.636,21.636,25,17.5,25z" /></g></g></svg></label></div>'
			).insertBefore("#easy-top"), $(document).on("click", "#halim-light-mode", (function () {
				$("body").toggleClass("halim-light-mode"), $("body").hasClass("halim-light-mode") ? localStorage
					.setItem("halim-light-mode", !0) : localStorage.setItem("halim-light-mode", !1)
			})), "undefined" != typeof Storage)) {
				var a = localStorage.getItem("halim-light-mode");
				"true" == a ? ($("body").addClass("halim-light-mode"), $("#halim-light-mode").prop("checked", !0)) : null !=
					a && ($("body").removeClass("halim-light-mode"), $("#halim-light-mode").prop("checked", !1))
			}
		},
		Rating: function () {
			$(".review-percentage .review-item span").each((function () {
				$g = $(this).find("span").attr("data-width"), HaLim.Progress($g, $(this))
			})), $(document).on("mousemove", ".user-rate-active", (function (a) {
				var e = $(this);
				if (e.hasClass("rated-done")) return !1;
				a.offsetX || (a.offsetX = a.clientX - $(a.target).offset().left);
				var t = a.offsetX + 4;
				t > 100 && (t = 100), e.find(".user-rate-image span").css("width", t + "%");
				var o = Math.floor(t / 10 * 5) / 10;
				o > 5 && (o = 5)
			})), $(document).on("click", ".user-rate-active", (function () {
				var a = $(this);
				if (a.hasClass("rated-done")) return !1;
				var e = a.find(".user-rate-image span").width();
				a.find(".user-rate-image").hide(), a.append('<span class="taq-load"></span>'), e > 100 && (e = 100),
					ngg = 5 * e / 100;
				var t = a.attr("data-id"),
					o = $(".total_votes").text();
				return $.post(halim_rate.ajaxurl, {
					action: "halim_rate_post",
					nonce: halim_rate.nonce,
					post: t,
					value: ngg
				}, (function (t) {
					a.addClass("rated-done").attr("data-rate", e), a.find(".user-rate-image span").width(e + "%"),
						$(".taq-load").fadeOut((function () {
							"Voted" !== t ? ($("span.score").html(ngg), $(".total_votes").html(parseInt(o) + 1), $(
								".tks").html(halim_rate.your_rating), $(".user-rate-image").fadeIn(), $(
									'[data-toggle="rate_this"]').popover("hide")) : ($(".user-rate-active").html(
										"You have already rated!"), $('[data-toggle="rate_this"]').popover("show"),
										setTimeout((function () {
											$('[data-toggle="rate_this"]').popover("hide")
										}), 2e3))
						}))
				}), "html"), !1
			})), $(document).on("mouseleave", ".user-rate-active", (function () {
				var a = $(this);
				if (a.hasClass("rated-done")) return !1;
				var e = a.attr("data-rate");
				a.find(".user-rate-image span").css("width", e + "%")
			}))
		},
		Progress: function (a, e) {
			e.find("span").animate({
				width: a + "%"
			}, 700)
		},
		EpisodeNavigation: function () {
			$("#server-episodes").change((function () {
				var a = $(this).val();
				$('a[href="' + a + '"]').tab("show")
			})), "undefined" != typeof jsonEpisodes && $.each(jsonEpisodes, (function (a, e) {
				! function (a, e) {
					var t = "";
					t += '<ul id="listsv-' + e + '" class="halim-list-eps">', $.each(a, (function (a, e) {
						e && (t += '<li data-href="' + e.postUrl + '" class="clickable halim-btn ' + e.activeItem +
							'halim-episode-item" data-post-id="' + e.postId + '" data-number="' + e.episodeName
								.toLowerCase() + '" data-server="' + e.serverId + '" data-episode-slug="' + e
								.episodeSlug + '" data-position="' + e.position + '" data-embed="' + e.embed + '">', e
									.activeItem && (t += '<div class="halim-pulse-ring"></div>'), t += '<a href="' + e
										.postUrl + '" title="' + e.episodeName + '"><span>' + e.episodeName + "</span></a>", t +=
							"</li>")
					})), t += "</ul>", $("#" + e).html(t)
				}(e, "server-" + a)
			}))
		},
		EpisodeItemSearch: function () {
			var a = null;
			$(".search-episode-item").keyup((function () {
				clearTimeout(a);
				var e = $(this).val().toLowerCase();
				$("ul.halim-list-eps").find("li").removeClass("matched"), $("#episode-result").hide(), a = setTimeout((
					function () {
						var a = $(".halim-server.active ul.halim-list-eps").find("li[data-number*='" + e + "']");
						a.addClass("matched"), $("#episode-result").show().html(a.html()), "" == e && $(
							"#episode-result").hide();
						var t = $('.halim-server.active ul.halim-list-eps li[data-number*="' + e + '"]')[0];
						void 0 !== t && t.scrollIntoView({
							behavior: "smooth",
							block: "center",
							inline: "nearest"
						})
					}), 200)
			}))
		}
	};

function is_Mobile() {
	var a, e = !1;
	return a = navigator.userAgent || navigator.vendor || window.opera, (
		/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i
			.test(a) ||
		/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i
			.test(a.substr(0, 4))) && (e = !0), e
}

function iOS() {
	return ["iPad Simulator", "iPhone Simulator", "iPod Simulator", "iPad", "iPhone", "iPod"].includes(navigator
		.platform) || navigator.userAgent.includes("Mac") && "ontouchend" in document
}
jQuery(document).ready((function (a) {
	HaLim.Init()
}));