!function(){"use strict";var t,e={136:function(){var t=window.wp.blocks,e=window.wp.element,o=window.wp.i18n,n=window.wp.blockEditor,i=JSON.parse('{"$schema":"https://json.schemastore.org/block.json","apiVersion":2,"name":"ts-block/hp-section-two","version":"0.1.0","title":"HP Section 2","category":"tstudio","icon":"welcome-widgets-menus","description":"Example block written with ESNext standard and JSX support – build step required.","supports":{"html":false},"textdomain":"hp-section-two","editorScript":"file:../../../build/js/hp-section-two/hp-section-two.js","editorStyle":"file:../../../build/css/hp-section-two.css","style":"file:../../../build/css/style-hp-section-two.css"}');const{name:r}=i;(0,t.registerBlockType)({name:r,...i},{edit:function(){return(0,e.createElement)("p",(0,n.useBlockProps)(),(0,o.__)("Multi Block Plugin – hello from the editor!","multi-block-plugin"))},save:function(){return(0,e.createElement)("p",n.useBlockProps.save(),(0,o.__)("Multi Block Plugin – hello from the saved content!","multi-block-plugin"))}})}},o={};function n(t){var i=o[t];if(void 0!==i)return i.exports;var r=o[t]={exports:{}};return e[t](r,r.exports,n),r.exports}n.m=e,t=[],n.O=function(e,o,i,r){if(!o){var s=1/0;for(p=0;p<t.length;p++){o=t[p][0],i=t[p][1],r=t[p][2];for(var l=!0,c=0;c<o.length;c++)(!1&r||s>=r)&&Object.keys(n.O).every((function(t){return n.O[t](o[c])}))?o.splice(c--,1):(l=!1,r<s&&(s=r));if(l){t.splice(p--,1);var u=i();void 0!==u&&(e=u)}}return e}r=r||0;for(var p=t.length;p>0&&t[p-1][2]>r;p--)t[p]=t[p-1];t[p]=[o,i,r]},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},function(){var t={886:0,441:0};n.O.j=function(e){return 0===t[e]};var e=function(e,o){var i,r,s=o[0],l=o[1],c=o[2],u=0;if(s.some((function(e){return 0!==t[e]}))){for(i in l)n.o(l,i)&&(n.m[i]=l[i]);if(c)var p=c(n)}for(e&&e(o);u<s.length;u++)r=s[u],n.o(t,r)&&t[r]&&t[r][0](),t[s[u]]=0;return n.O(p)},o=self.webpackChunkmulti_block_plugin=self.webpackChunkmulti_block_plugin||[];o.forEach(e.bind(null,0)),o.push=e.bind(null,o.push.bind(o))}();var i=n.O(void 0,[441],(function(){return n(136)}));i=n.O(i)}();