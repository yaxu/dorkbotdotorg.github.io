<public:component>
<public:attach event="onpropertychange" onevent="doFix()" />

<script type="text/javascript">

// IE5.5+ PNG Alpha Fix v1.0RC4
// (c) 2004-2005 Angus Turnbull http://www.twinhelix.com

// This is licensed under the CC-GNU LGPL, version 2.1 or later.
// For details, see: http://creativecommons.org/licenses/LGPL/2.1/

// Since we need to know the full path inside DokuWiki, I moved this into main.php
// if (typeof blankImg == 'undefined') var blankImg = 'blank.gif';

var f = 'DXImageTransform.Microsoft.AlphaImageLoader';

function filt(s, m)
{
 if (filters[f])
 {
  filters[f].enabled = s ? true : false;
  if (s) with (filters[f]) { src = s; sizingMethod = m }
 }
 else if (s) style.filter = 'progid:'+f+'(src="'+s+'",sizingMethod="'+m+'")';
}
//else if (s) style.filter = 'progid:'+f+'(src="'+s+'",sizingMethod="scale ")';
function doFix()
{
 // Assume IE7 is OK.
 if (!/MSIE (5\.5|6\.)/.test(navigator.userAgent) ||
  (event && !/(background|src)/.test(event.propertyName))) return;

 var bgImg = currentStyle.backgroundImage || style.backgroundImage;

 if (tagName == 'IMG')
 {
  if ((/\.png$/i).test(src))
  {
   if (currentStyle.width == 'auto' && currentStyle.height == 'auto')
    style.width = offsetWidth + 'px';
   filt(src, 'scale');
   src = blankImg;
  }
  else if (src.indexOf(blankImg) < 0) filt();
 }
 else if (bgImg && bgImg != 'none')
 {
  if (bgImg.match(/^url[("']+(.*\.png)[)"']+$/i))
  {
   var s = RegExp.$1;
   if (currentStyle.width == 'auto' && currentStyle.height == 'auto')
    style.width = offsetWidth + 'px';
   style.backgroundImage = 'none';
   if(currentStyle.backgroundRepeat=="repeat")
    filt(s, 'scale');
   else
    filt(s, 'crop');
   // IE link fix.
   for (var n = 0; n < childNodes.length; n++)
    if (childNodes[n].style) childNodes[n].style.position = 'relative';
  }
  else filt();
 }
}

doFix();

</script>
</public:component>
