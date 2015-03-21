function Trim(string){
// return the string extracting spaces
// from the beggining and from the end

  var length=string.length,end_limit=length-1,begin_limit=0;
  var space = true;

  while(space && begin_limit<length){
    if (string.substr(begin_limit,1)==" ")
      begin_limit++;
    else
      space=false;
  }
  if (space) return "";

  space = true;
  while(space && (end_limit>begin_limit-1)){
    if (string.substr(end_limit,1)==" ")
      end_limit--;
    else
      space=false;
  }

  return string.substr(begin_limit,end_limit-begin_limit+1);

}

function IsEmpty(val){
  return (val=="");
}

function IsNothing(val){
  return (Trim(val)=="");
}


function ScrollSelect(sel){
  //function used as workaround for Mozilla bug:
  // http://bugzilla.mozilla.org/show_bug.cgi?id=224023

  if (sel.selectedIndex>0){
    sel.selectedIndex--;
    sel.selectedIndex++;
  }
}

function GoBack(){
  window.history.back();
  return false;
}

function OneWord(string){
// if string has no spaces inside the trimmed string:
//   returns true 

  var length,i=0,space=false;
  var trimmed = Trim(string);

  length = trimmed.length;
  while(!space && (i<length)){
    if (trimmed.substr(i,1)==" ")
      space=true;
    else
      i++;    
  }

  return !space;
}

function TextsRbutton(array_txt,btn){
// if any of the texts is not empty:
//   button is enabled
// else: button is disabled

  var empty = true;
  var i = 0;

  while(empty && i<array_txt.length){
    empty = IsEmpty(array_txt[i].value);
    i++;
  }

  btn.disabled = empty;
}

function TextSbutton(txt,btn){
// if text trims to empty:
//   button is disabled
// else: button is enabled

  btn.disabled = IsNothing(txt.value);
}

function SelectButton(sel,btn){
// if no index is selected on the list:
//   button is disabled
// else: button is enabled

  btn.disabled = (sel.selectedIndex<0);
}

function Select0Button(sel,btn){
// if first index or none is selected on the list:
//   button is disabled
// else: button is enabled

  btn.disabled = (sel.selectedIndex<1);
}

function FormResetSubmitText(frm,btn_reset,btn_submit,txt){
// function for the "onclick" event of a reset button:
// disables the buttons "reset" and "submit"
// and sets the focus to the "txt"

  frm.reset();
  btn_reset.disabled = true;
  btn_submit.disabled = true;
  txt.focus();
}

function CheckedDisabled(roc,ele){
// if radio-or-checkbox(roc) is checked: element is enabled
// else: element is disabled

  ele.disabled = !roc.checked;
}
