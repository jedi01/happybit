// Dragable functions
// usage
// <div onmousedown='grab(this, event)'>
//    <div>Header</div>
//    <div onmousedown='grab(false, event);' >body</div>
// </div>

var mousex = 0;
var mousey = 0;
var grabx = 0;
var graby = 0;
var orix = 0;
var oriy = 0;
var elex = 0;
var eley = 0;
var algor = 0;

var dragobj = null;

function falsefunc() { return false; } // used to block cascading events

function init_drag()
{
  document.onmousemove = update; // update(event) implied on NS, update(null) implied on IE
  update();
}

function getMouseXY(e) // works on IE6,FF,Moz,Opera7
{ 
  if (!e) e = window.event; // works on IE, but not NS (we rely on NS passing us the event)

  if (e)
  { 
    if (e.pageX || e.pageY)
    { // this doesn't work on IE6!! (works on FF,Moz,Opera7)
      mousex = e.pageX;
      mousey = e.pageY;
      algor = '[e.pageX]';
      if (e.clientX || e.clientY) algor += ' [e.clientX] '
    }
    else if (e.clientX || e.clientY)
    { // works on IE6,FF,Moz,Opera7
      mousex = e.clientX + document.body.scrollLeft;
      mousey = e.clientY + document.body.scrollTop;
      algor = '[e.clientX]';
      if (e.pageX || e.pageY) algor += ' [e.pageX] '
    }  
  }
}

function update(e)
{
  getMouseXY(e); // NS is passing (event), while IE is passing (null)

}

function grab(context, evt)
{
  if(context != false){
    document.onmousedown = falsefunc; // in NS this prevents cascading of events, thus disabling text selection
    dragobj = context;
    dragobj.style.zIndex = 10; // move it to the top
    document.onmousemove = drag;
    document.onmouseup = drop;
    grabx = mousex;
    graby = mousey;
    elex = orix = dragobj.offsetLeft;
    eley = oriy = dragobj.offsetTop;
    update();
  }else{
    if (!evt) evt = window.event; // works on IE, but not NS (we rely on NS passing us the event)
    evt.cancelBubble = true;
    evt.returnValue = false;
    //e.stopPropagation works only in Firefox.
	if (evt.stopPropagation) {
		evt.stopPropagation();
		evt.preventDefault();
	}
	return false;
  }
}

function drag(e) // parameter passing is important for NS family 
{
  if (dragobj)
  {
    elex = orix + (mousex-grabx);
    eley = oriy + (mousey-graby);
    dragobj.style.position = "absolute";
    dragobj.style.left = (elex).toString(10) + 'px';
    dragobj.style.top  = (eley).toString(10) + 'px';
  }
  update(e);
  return false; // in IE this prevents cascading of events, thus text selection is disabled
}

function drop()
{
  if (dragobj)
  {
    dragobj.style.zIndex = 0;
    dragobj = null;
  }
  update();
  document.onmousemove = update;
  document.onmouseup = null;
  document.onmousedown = null;   // re-enables text selection on NS
}


init_drag();