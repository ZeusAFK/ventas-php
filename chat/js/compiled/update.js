/*!
 * This file is a part of Mibew Messenger.
 *
 * Copyright 2005-2014 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
!function(e){var i=function(){if("undefined"!=typeof window.mibewNews&&"undefined"!=typeof window.mibewNews.length){for(var i="<div>",w=0;w<window.mibewNews.length;w++)i+='<div class="news-title"><a href="'+window.mibewNews[w].link+'">'+window.mibewNews[w].title+'</a>, <span class="small">'+window.mibewNews[w].date+"</span></div>",i+='<div class="news-text">'+window.mibewNews[w].message+"</div>";e("#news").html(i+"</div>")}},w=function(){if("undefined"!=typeof window.mibewLatest&&"undefined"!=typeof window.mibewLatest.version){var i=e("#current-version").html();i!=window.mibewLatest.version?(i<window.mibewLatest.version&&e("#current-version").css("color","red"),e("#latest-version").html(window.mibewLatest.version+', Download <a href="'+window.mibewLatest.download+'">'+window.mibewLatest.title+"</a>")):(e("#current-version").css("color","green"),e("#latest-version").html(window.mibewLatest.version))}};e(function(){i(),w()})}(jQuery);