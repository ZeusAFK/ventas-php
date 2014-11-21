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
!function(e,i){e.Views.Visitor=e.Views.CompositeBase.extend({template:i.templates["users/visitor"],itemView:e.Views.Control,itemViewContainer:".visitor-controls",className:"visitor",modelEvents:{change:"render"},events:{"click .invite-link":"inviteUser","click .geo-link":"showGeoInfo","click .track-control":"showTrack"},inviteUser:function(){if(!this.model.get("invitationInfo")){var i=this.model.id,t=e.Objects.Models.page;e.Popup.open(t.get("inviteLink")+"?visitor="+i,"ImCenter"+i,t.get("inviteWindowParams"))}},showTrack:function(){var i=this.model.id,t=e.Objects.Models.page;e.Popup.open(t.get("trackedLink")+"?visitor="+i,"ImTracked"+i,t.get("trackedVisitorWindowParams"))},showGeoInfo:function(){var i=this.model.get("userIp");if(i){var t=e.Objects.Models.page,o=t.get("geoLink").replace("{ip}",i);e.Popup.open(o,"ip"+i,t.get("geoWindowParams"))}}})}(Mibew,Handlebars);