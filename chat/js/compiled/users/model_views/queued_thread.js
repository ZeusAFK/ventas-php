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
!function(e,t){e.Views.QueuedThread=e.Views.CompositeBase.extend({template:t.templates["users/queued_thread"],itemView:e.Views.Control,itemViewContainer:".thread-controls",className:"thread",modelEvents:{change:"render"},events:{"click .open-dialog":"openDialog","click .view-control":"viewDialog","click .track-control":"showTrack","click .ban-control":"showBan","click .geo-link":"showGeoInfo","click .first-message a":"showFirstMessage"},initialize:function(){this.lastStyles=[]},serializeData:function(){var t=this.model,s=e.Objects.Models.page,i=t.toJSON();return i.stateDesc=this.stateToDesc(t.get("state")),i.chatting=t.get("state")==t.STATE_CHATTING,i.tracked=s.get("showVisitors"),i.firstMessage&&(i.firstMessagePreview=i.firstMessage.length>30?i.firstMessage.substring(0,30)+"...":i.firstMessage),i},stateToDesc:function(t){var s=e.Localization;return t==this.model.STATE_QUEUE?s.trans("In queue"):t==this.model.STATE_WAITING?s.trans("Waiting for operator"):t==this.model.STATE_CHATTING?s.trans("In chat"):t==this.model.STATE_CLOSED?s.trans("Closed"):t==this.model.STATE_LOADING?s.trans("Loading"):""},showGeoInfo:function(){var t=this.model.get("userIp");if(t){var s=e.Objects.Models.page,i=s.get("geoLink").replace("{ip}",t);e.Popup.open(i,"ip"+t,s.get("geoWindowParams"))}},openDialog:function(){var e=this.model;if(e.get("canOpen")||e.get("canView")){var t=!e.get("canOpen");this.showDialogWindow(t)}},viewDialog:function(){this.showDialogWindow(!0)},showDialogWindow:function(t){var s=this.model,i=s.id,a=e.Objects.Models.page;e.Popup.open(a.get("agentLink")+"/"+i+(t?"?viewonly=true":""),"ImCenter"+i,a.get("chatWindowParams"))},showTrack:function(){var t=this.model.id,s=e.Objects.Models.page;e.Popup.open(s.get("trackedLink")+"?thread="+t,"ImTracked"+t,s.get("trackedUserWindowParams"))},showBan:function(){var t=this.model,s=t.get("ban"),i=e.Objects.Models.page;e.Popup.open(i.get("banLink")+"/"+(s!==!1?s.id+"/edit":"add?thread="+t.id),"ImBan"+s.id,i.get("banWindowParams"))},showFirstMessage:function(){var e=this.model.get("firstMessage");e&&alert(e)}})}(Mibew,Handlebars);