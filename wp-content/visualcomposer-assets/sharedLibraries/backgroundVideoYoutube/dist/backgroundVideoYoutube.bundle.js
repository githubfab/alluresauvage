!function(e){function t(o){if(i[o])return i[o].exports;var r=i[o]={exports:{},id:o,loaded:!1};return e[o].call(r.exports,r,r.exports,t),r.loaded=!0,r.exports}var i={};return t.m=e,t.c=i,t.p=".",t(0)}({"./src/backgroundVideoYoutube.js":function(e,t){"use strict";window.vcv.on("ready",function(e,t){if("merge"!==e){var i="[data-vce-assets-video-yt]";i=t?'[data-vcv-element="'+t+'"] '+i:i,window.vceAssetsBackgroundVideoYoutube(i)}})},"./src/plugin.js":function(e,t){"use strict";!function(e,t){function i(t){var i={element:null,player:null,ytPlayer:null,videoId:null,resizer:null,ratio:null,setup:function(t){return t.getVceYoutubeVideo?this.updatePlayer():(t.getVceYoutubeVideo=this,this.element=t,this.resizer=t.querySelector("svg"),this.checkYT(),this.checkOrientation=this.checkOrientation.bind(this),e.addEventListener("resize",this.checkOrientation)),t.getVceYoutubeVideo},updatePlayerData:function(){this.player=t.querySelector(t.dataset.vceAssetsVideoReplacer),this.videoId=t.dataset.vceAssetsVideoYt||null},checkYT:function(){var e=arguments.length<=0||void 0===arguments[0]?0:arguments[0];if("undefined"==typeof YT||!YT.loaded){if(e>100)return void console.log("Too many attempts to load YouTube IFrame API");var t=this;return void setTimeout(function(){e++,t.checkYT(e)},100)}this.createPlayer()},createPlayer:function(){var e=this;this.updatePlayerData(),this.ytPlayer=new YT.Player(this.player,{videoId:this.videoId,playerVars:{autoplay:1,start:0,modestbranding:1,controls:0,disablekb:1,fs:0,iv_load_policy:3,loop:1,playlist:this.videoId,rel:0,showinfo:0},events:{onReady:function(t){var i=t.target.a.getAttribute("height"),o=t.target.a.getAttribute("width");e.resizer.setAttribute("height",i),e.resizer.setAttribute("width",o),e.resizer.setAttribute("data-vce-assets-video-state","visible"),e.ratio=parseInt(o)/parseInt(i),e.checkOrientation(),t.target.mute()}}})},updatePlayer:function(){this.ytPlayer.destroy(),this.createPlayer()},checkOrientation:function(){var t=this.element.dataset.vceAssetsVideoOrientationClass||null,i=e.getComputedStyle(this.element.parentNode);t&&(parseInt(i.width)/parseInt(i.height)>this.ratio?this.element.classList.add(t):this.element.classList.remove(t))}};return i.setup(t)}function o(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:0;return"undefined"!=typeof YT&&YT.loaded?void r.init(e):t>100?void console.log("Too many attempts to load YouTube IFrame API"):void setTimeout(function(){t++,o(e,t)},100)}var r={init:function(e){var o=t.querySelectorAll(e);return o=[].slice.call(o),o.forEach(function(e){e.getVceYoutubeVideo?e.getVceYoutubeVideo.updatePlayer():i(e)}),1===o.length?o.pop():o}};e.vceAssetsBackgroundVideoYoutube=o}(window,document)},"./src/youtubeIframeApi.js":function(e,t){"use strict";!function(e,t){var i=t.getElementById("vcv-asset-youtube-iframe-api");if(!i){var o=t.createElement("script");o.id="vcv-asset-youtube-iframe-api",o.src="https://www.youtube.com/iframe_api",t.head.appendChild(o)}}(window,document)},"./src/backgroundVideoYoutube.css":function(e,t){},0:function(e,t,i){i("./src/youtubeIframeApi.js"),i("./src/plugin.js"),i("./src/backgroundVideoYoutube.js"),e.exports=i("./src/backgroundVideoYoutube.css")}});