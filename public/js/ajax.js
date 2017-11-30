/*

*/
// recupere le contenu des posts dans le modal
let postId = 0;
let postElmt;
let postPannel = $('.post-pannel');
const dashboard = $("#dashboard");


$('.edit').find('a').on('click', function(e) {

    e.preventDefault();
    postElmt = e.target.parentNode.parentNode;
    console.log(postElmt);

    let postText = postElmt.childNodes[3].childNodes[1].textContent;
    postId = postElmt.dataset['postid'];
    console.log(postText);
    $('#post-content').val(postText);
    $("#edit-modal").modal();

});

// edit post

$('#modal-save').on('click', function(e) {

    $.ajax({
        method: 'POST',
        url: url,
        data: { content: $('#post-content').val(), postId: postId, _token: token }

    }).done(function(reponse) {
        $(postElmt.childNodes[3].childNodes[1]).text(reponse['new_content']);
        $('#edit-modal').modal('hide');
    })
});


$("#post-form").submit('click', function(e) {
    e.preventDefault();
    console.log(this);
    let url = $(this)[0].action;
    $.ajax(url, {
        method: 'POST',
        //dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': token
        },
        contentType: false,
        processData: false,
        enctype: 'multipart/form-data',
        data: new FormData(this)



    }).done(e, function(reponse) {
        console.log(reponse);
        $(".post-dashboard").empty();
        $(reponse).prependTo(".post-dashboard");
        $('#content').val('');
    }).fail(function(err) {
        console.error(err);
    })
})


//delete post 

$('.delete-post').find('a').on('click', function(e) {
    e.preventDefault();
    let a = $(this);
    postElmt = event.target.parentNode.parentNode;
    $.ajax({
        url: a.attr('href'),
        method: 'GET'

    }).done(function(reponse) {
        console.log(reponse);
        console.log($(".post-dashboard")[0].removeChild(postElmt));
    }).fail(function(jqxhr) {
        alert(jqxhr.responseText);
    })
})