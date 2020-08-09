<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://blueimp.github.io/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>

<script src="https://blueimp.github.io/jQuery-File-Upload/js/jquery.fileupload.js"></script>

<style>
.file {
   position: relative;
   background: linear-gradient(to right, lightblue 50%, transparent 50%);
   background-size: 200% 100%;
   background-position: right bottom;
   transition:all 1s ease;
}
 .file.done {
   background: lightgreen;
}
 .file a {
   display: block;
   position: relative;
   padding: 5px;
   color: black;
}

</style>
</head>
<body>


  <input id="fileupload" type="file" name="files[]" data-url="https://host.local.dev-sys/index/home/sendMessage" multiple> multiple>

  
</form>
<script>

$(document).ready(function(){

  $("#fileupload").fileupload({

  type: 'POST',

  url: "https://host.local.dev-sys/index/home/blobAzureImages",

  add: function(e, data) {
    data.context = $('<p class="file">')
      .append($('<a target="_blank">').text(data.files[0].name))
      .appendTo(document.body);
    data.submit();
  },
  progress: function(e, data) {
    var progress = parseInt((data.loaded / data.total) * 100, 10);
    data.context.css("background-position-x", 100 - progress + "%");
  },
  done: function(e, data) {
    data.context
      .addClass("done")
      .find("a")
      .prop("href", data.result.files[0].url);
  }
});
});


</script>


</body>
</html>