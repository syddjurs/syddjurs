CKEDITOR.on('dialogDefinition', function(ev) {
  // Take the dialog name and its definition from the event data.
  var dialogName = ev.data.name;
  var dialogDefinition = ev.data.definition;
  

  // Check if the definition is from the dialog we're
  // interested in (the "Link" dialog).
  if (dialogName == 'image') {
    // Get a reference to the "Info" tab.
    var infoTab = dialogDefinition.getContents('info');
    
    // Remove some items from the "info" tab.
    infoTab.remove("txtWidth");
    infoTab.remove("txtHeight");
    infoTab.remove("ratioLock");
  }
});
