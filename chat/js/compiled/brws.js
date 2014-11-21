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
function detectAgent(){for(var e=["opera","msie","safari","firefox","netscape","mozilla"],t=navigator.userAgent.toLowerCase(),n=0;n<e.length;n++){var a=e[n];if(-1!=t.indexOf(a)){if(myAgent=a,!window.RegExp)break;var r=new RegExp(a+"[ /]?([0-9]+(.[0-9]+)?)");null!=r.exec(t)&&(myVer=parseFloat(RegExp.$1));break}}myRealAgent=myAgent,"Gecko"==navigator.product&&(myAgent="moz")}function getEl(e){return document.getElementById(e)}var myAgent="",myVer=0,myRealAgent="";detectAgent();