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
!function(){Handlebars.templates=Handlebars.templates||{};Handlebars.templates.default_control=Handlebars.template(function(a,e,l,t,s){this.compilerInfo=[4,">= 1.0.0"],l=this.merge(l,a.helpers),s=s||{};var n,r,c="",p="function",h=this.escapeExpression;return c+="<strong>",(r=l.title)?n=r.call(e,{hash:{},data:s}):(r=e&&e.title,n=typeof r===p?r.call(e,{hash:{},data:s}):r),c+=h(n)+"</strong>"})}(),function(){Handlebars.templates=Handlebars.templates||{};Handlebars.templates.message=Handlebars.template(function(a,e,l,t,s){function n(a,e){var t,s,n="";return n+="<span class='n",(s=l.kindName)?t=s.call(a,{hash:{},data:e}):(s=a&&a.kindName,t=typeof s===m?s.call(a,{hash:{},data:e}):s),n+=o(t)+"'>",(s=l.name)?t=s.call(a,{hash:{},data:e}):(s=a&&a.name,t=typeof s===m?s.call(a,{hash:{},data:e}):s),n+=o(t)+"</span>: "}function r(a,e){var t,s;return o((t=l.urlReplace||a&&a.urlReplace,s={hash:{},data:e},t?t.call(a,a&&a.message,s):d.call(a,"urlReplace",a&&a.message,s)))}this.compilerInfo=[4,">= 1.0.0"],l=this.merge(l,a.helpers),s=s||{};var c,p,h,i="",m="function",o=this.escapeExpression,d=l.helperMissing,f=this;return i+="<span>"+o((p=l.formatTime||e&&e.formatTime,h={hash:{},data:s},p?p.call(e,e&&e.created,h):d.call(e,"formatTime",e&&e.created,h)))+"</span>\n",c=l["if"].call(e,e&&e.name,{hash:{},inverse:f.noop,fn:f.program(1,n,s),data:s}),(c||0===c)&&(i+=c),i+="\n<span class='m",(p=l.kindName)?c=p.call(e,{hash:{},data:s}):(p=e&&e.kindName,c=typeof p===m?p.call(e,{hash:{},data:s}):p),i+=o(c)+"'>",p=l.replace||e&&e.replace,h={hash:{},inverse:f.noop,fn:f.program(3,r,s),data:s},c=p?p.call(e,"\\n","<br/>",h):d.call(e,"replace","\\n","<br/>",h),(c||0===c)&&(i+=c),i+="</span><br/>"})}();