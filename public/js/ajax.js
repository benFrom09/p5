/*

*/
// recupere le contenu des posts dans le modal
let postId = 0;
let postElmt;
let postPannel = $('.post-pannel');
const dashboard = $("#dashboard");


$('.edit').find('a').on('click', function(event) {

    event.preventDefault();
    postElmt = event.target.parentNode.parentNode.childNodes[3].childNodes[1];

    let postText = postElmt.textContent;
    postId = event.target.parentNode.parentNode.childNodes[3].dataset['postid'];
    //console.log(postId);
    $('#post-content').val(postText);
    $("#edit-modal").modal();

});

// edit post

$('#modal-save').on('click', function(e) {

    $.ajax({
        method: 'POST',
        url: url,
        data: { content: $('#post-content').val(), post_images: $('#file-upload').val(), postId: postId, _token: token }

    }).done(function(msg) {
        $(postElmt).text(msg['new_content']);
        $('#edit-modal').modal('hide');
    })
});

//create post

$('#post-submit').on('click', function(e) {
    e.preventDefault();
    $.ajax({
        method: 'POST',
        dataType: 'json',

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $('#post-form')[0].action,
        data: { content: $('#content').val() }



    }).done(function(data) {
        console.log(data);
        //$(".post-dashboard").empty();
        $(data).prependTo(".post-dashboard");
        $('#content').val('');
    }).fail(function(jqxhr) {
        alert(jqxhr.responseText);
    })

})

//delete post 
/*
$('.delete-post').find('a').on('click', function(e) {
    e.preventDefault();
    let a = $(this);
    $.ajax({
        url: a.attr('href'),
        type: 'DELETE'

    }).done(function(data) {
        console.log(data);
    }).fail(function(jqxhr) {
        alert(jqxhr.responseText);
    })
})

*/