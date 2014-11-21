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
!function(e,t,i){e.Views.ThreadsCollection=e.Views.CompositeBase.extend({template:t.templates["users/threads_collection"],itemView:e.Views.QueuedThread,itemViewContainer:"#threads-container",emptyView:e.Views.NoThreads,className:"threads-collection",collectionEvents:{sort:"render","sort:field":"createSortField",add:"threadAdded"},itemViewOptions:function(t){var i=e.Objects.Models.page;return{tagName:i.get("threadTag"),collection:t.get("controls")}},initialize:function(){window.setInterval(i.bind(this.updateTimers,this),2e3),this.on("itemview:before:render",this.updateStyles,this),this.on("composite:collection:rendered",this.updateTimers,this)},updateStyles:function(e){var t=this.collection,i=e.model,s=this;if(i.id){var n=this.getQueueCode(i),a=!1,o=!1,l=t.filter(function(e){return s.getQueueCode(e)==n});if(l.length>0&&(o=l[0].id==i.id,a=l[l.length-1].id==i.id),e.lastStyles.length>0){for(var r=0,d=e.lastStyles.length;d>r;r++)e.$el.removeClass(e.lastStyles[r]);e.lastStyles=[]}var E=(n!=this.QUEUE_BAN?"in":"")+this.queueCodeToString(n);e.lastStyles.push(E),o&&e.lastStyles.push(E+"-first"),a&&e.lastStyles.push(E+"-last");for(var r=0,d=e.lastStyles.length;d>r;r++)e.$el.addClass(e.lastStyles[r])}},updateTimers:function(){e.Utils.updateTimers(this.$el,".timesince")},createSortField:function(e,t){var i=this.getQueueCode(e)||"Z";t.field=i.toString()+"_"+e.get("waitingTime").toString()},threadAdded:function(){var t=e.Objects.Models.page.get("mibewBasePath");"undefined"!=typeof t&&(t+="/sounds/new_user",e.Utils.playSound(t)),e.Objects.Models.page.get("showPopup")&&this.once("render",function(){alert(e.Localization.trans("A new visitor is waiting for an answer."))})},getQueueCode:function(e){var t=e.get("state");return 0!=e.get("ban")&&t!=e.STATE_CHATTING?this.QUEUE_BAN:t==e.STATE_QUEUE||t==e.STATE_LOADING?this.QUEUE_WAITING:t==e.STATE_CLOSED||t==e.STATE_LEFT?this.QUEUE_CLOSED:t==e.STATE_WAITING?this.QUEUE_PRIO:t==e.STATE_CHATTING?this.QUEUE_CHATTING:!1},queueCodeToString:function(e){return e==this.QUEUE_PRIO?"prio":e==this.QUEUE_WAITING?"wait":e==this.QUEUE_CHATTING?"chat":e==this.QUEUE_BAN?"ban":e==this.QUEUE_CLOSED?"closed":""},QUEUE_PRIO:1,QUEUE_WAITING:2,QUEUE_CHATTING:3,QUEUE_BAN:4,QUEUE_CLOSED:5})}(Mibew,Handlebars,_);