/*

/*************************************************************************
 * AJAX REQUEST JS
 *************************************************************************/
// recupere le contenu des posts dans le modal

let postId = 0;
let postElmt;
let postPannel = $('.post-pannel');
let posts = [];
const dashboard = $("#dashboard");
let postBody = $(".post-body");
let dashboardContent = $(".dashboard-list");
const URL = 'https://opengraph.io/api/1.0/site';
const id = '59fca8d730b7020b00f62836';
//console.log(postBody);

postPannel.map(function(element) {
    //console.log('PANNEL ', postPannel[element].childNodes[3].childNodes[1].textContent);
    let text = postPannel[element].childNodes[3].childNodes[1].textContent;
    //console.log(postBody[element].textContent);
    if (text.match(/http/)) {
        alert('matches : ' + postBody[element] + ' ' + postBody[element].textContent);
        let url = encodeURIComponent(text);
        fetch(URL + '/' + url + '?app_id=' + id)
            .then(response => {
                return response.json();

            })
            .then(data => {
                if (Object.getOwnPropertyNames(data)[0] === "error") {
                    console.log('houuuuuuuuuura');
                    if (data.error.code === 101) {
                        var post = {
                            text: data.error.message
                        };
                        console.log(postPannel[element].childNodes[3].childNodes[1]);
                        displayErrors(post, postPannel[element].childNodes[3].childNodes[1]);
                    }
                }

                var post = {
                    title: data.hybridGraph.title,
                    image: data.hybridGraph.image,
                    link: data.hybridGraph.url,
                    text: data.hybridGraph.description,
                    error: data.error
                };
                //console.log(post);
                posts.push(post);
                console.log(posts);
                displayPost(posts);
                posts = [];
                //storePost(posts);
                //dashboardForm.reset();

            }).catch(function(response) {
                console.log('ceci est une erreur :', response);
            });
    }
});



/*************************************************************************
 * EDIT POST
 *************************************************************************/

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

$("#content").on('focusout', function(e) {
    if ($("#content").val().match(/http/)) {
        let url = encodeURIComponent($("#content").val());
        fetch(URL + '/' + url + '?app_id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.error === 101) {
                    console.log(data.error);
                }

                var post = {
                    title: data.hybridGraph.title,
                    image: data.hybridGraph.image,
                    link: data.hybridGraph.url,
                    text: data.hybridGraph.description,
                    error: data.error
                };
                // console.log(post);
                posts.push(post);
                //console.log(posts);
                fillDashboard(posts);
                //storePost(posts);
                //dashboardForm.reset();

            }).catch(function(error) {
                console.log('ceci est une erreur :', error);
            });
    }
});


/*************************************************************************
 * fillDashBoard
 *************************************************************************/
function fillDashboard(post) {
    var postsHtml = posts.map(function(post, i) {
        if (post.link || post.image) {
            return `<div class="dashboard-post" data-id="${i}"><p><a href="${post.link}">${post.title}</a></p><p><img class="img-responsive" src="${post.image}"/></p><p>${post.text}</p><span class="glyphicon glyphicon-remove"></span></div>`;
        } else {
            return `<div class="dashboard-post" data-id="${i}"><p>${post.title}</p><span class="glyphicon glyphicon-remove"></span></div>`;
        }

    }).join('');
    console.log('postHtml : ', postsHtml);
    dashboardContent.html(postsHtml);
}

function storePost(data, e) {
    console.log(data);
    $.ajax(url, {
        method: 'POST',
        //dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': token
        },
        contentType: false,
        processData: false,
        enctype: 'multipart/form-data',
        data: new FormData($("#post-form"))



    }).done(e, function(reponse) {
        console.log(reponse);
        $(".post-dashboard").empty();
        $(reponse).prependTo(".post-dashboard");
        $('#content').val('');
    }).fail(function(err) {
        console.error(err);
    });
}

function removePost(e) {
    if (!e.target.matches('.glyphicon-remove')) {
        return;
    }
    console.log('hello');
    var index = e.target.parentNode.dataset.id;
    posts.splice(index, 1);
    fillDashboard(posts);
    $("#post-form")[0].reset();
    //storePost(posts);

}
dashboardContent.on('click', removePost);

function displayPost(post) {
    console.log('displayPost :', post);

}

function displayErrors(data, target) {
    let post = document.createElement("div");
    post.classList.add("dashboard-post");
    post.textContent = data.text;
    //let postHtml = `<div class="dashboard-post"><p>${data.text}</p></div>`;
    //console.log(target);
    return target.after(post);

}


/*************************************************************************
 * CREATE POST
 *************************************************************************/

$("#post-form").submit('click', function(e) {
    e.preventDefault();

    console.log(this);
    let url = $(this)[0].action;
    //storePost(this, e);

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

});



/*************************************************************************
 * DELETE POST
 *************************************************************************/

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
});