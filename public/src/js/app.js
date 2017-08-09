var postId = 0;
var eventId = 0;
var postBodyElement = null;

$('.post').find('.interaction').find('.edit').on('click', function (event) {
   event.preventDefault();

   postBodyElement = event.target.parentNode.parentNode.childNodes[1];
   var postBody = postBodyElement.textContent;
   postId = event.target.parentNode.parentNode.parentNode.dataset['postid'];
   $('#post-body').val(postBody);
   $('#edit-modal').modal();
});

$('#modal-save').on('click', function () {
   $.ajax({
      method: 'POST',
      url: urlEdit,
      data: {body: $('#post-body').val(), postId: postId, _token: token}
   })
   .done(function (msg) {
      $(postBodyElement).text(msg['new_body']);
      $('#edit-modal').modal('hide');
   });
});

$('.like').on('click', function(event) {
   event.preventDefault();
   postId = event.target.parentNode.parentNode.parentNode.dataset['postid'];
   var isLike = event.target.innerText;
   $.ajax({
      method: 'POST',
      url: urlLike,
      data: {isLike: isLike, postId: postId, _token: token}
   })
   .done(function(data) {
      event.target.previousElementSibling.innerText = data.num_likes + " likes this post.";
      if (isLike == "Like") {
         event.target.innerText = 'Dislike';
      } else {
         event.target.innerText = 'Like';
      }
   });
});

$('.going').on('click', function(event) {
   event.preventDefault();
   eventId = event.target.parentNode.parentNode.parentNode.dataset['eventid'];
   var isGoing = event.target.innerText;

   console.log('isGoing ' + isGoing);
   console.log('eventId ' + eventId);
   $.ajax({
      method: 'POST',
      url: urlGoing,
      data: {isGoing: isGoing, eventId: eventId, _token: token}
   })
   .done(function(data) {
      event.target.previousElementSibling.innerText = data.num_goings + " will go to this event.";
      console.log('data '+ data);
      if (isGoing == "Will go") {
         event.target.innerText = 'Going';
      } else {
         event.target.innerText = 'Will go';
      }
   });
});

$('#datepicker').datepicker({
   format: 'yyyy-mm-dd'
});

$("#menu-toggle").click(function(e) {
   e.preventDefault();
   $("#wrapper").toggleClass("toggled");
   $("#menu-toggle").toggleClass("glyphicon-menu-left");
   $("#menu-toggle").toggleClass("glyphicon-menu-right");
});

//opinions
$('#opinion').on('click', function (event) {
   event.preventDefault();
   $('#opinion-modal').modal();
});

$('#modal-opinion-save').on('click', function () {
   $.ajax({
      method: 'POST',
      url: urlOpinion,
      data: {body: $('#opinion-body').val(), _token: token}
   })
   .done(function () {
      alert('opinion submitted successfully');
      $('#opinion-modal').modal('hide');
   });
});
