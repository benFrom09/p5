let dashboardContent = document.querySelector(".dashboard-list");
let postId = 0;
let postElmt;
let postPannel = $('.post-pannel');
let posts = [];
const dashboard = $("#dashboard");
let postBody = $(".post-body");
const URL = 'https://opengraph.io/api/1.0/site';
const id = '59fca8d730b7020b00f62836';

function fileSelectionPreview(evt) {
    let files = evt.target.files; //return array
    for (var i = 0; i < files.length; i++) {
        if (!files[i].type.match('image.*')) {
            continue;
        }

        let dashboardPost = document.createElement('div');
        dashboardPost.classList.add('dashboard-post');
        let icon = document.createElement('span');
        icon.classList.add('glyphicon', 'glyphicon-remove');
        let img = document.createElement("img");
        img.classList.add("img-thumbnail");
        img.file = files[i];
        dashboardContent.appendChild(dashboardPost);
        dashboardPost.appendChild(img);
        dashboardContent.appendChild(icon);
        let reader = new FileReader();
        reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
        reader.readAsDataURL(files[i]);

    }
}


function removeImagePreview() {
    dashboardContent.innerHTML = '';
    $("#post-form")[0].reset();
}

function getFileName() {
    return $("#file-upload")[0].files[0].name;


}

/*************************************************************************
 * fillDashBoard
 *************************************************************************/
function fillDashboard(post) {
    var postsHtml = posts.map(function(post, i) {
        if (post.link || post.image) {
            if (post.text === undefined) {
                post.text = '';
            }
            return `<div class="dashboard-post" data-id="${i}"><p><a href="${post.link}">${post.title}</a></p><p><img class="img-responsive" src="${post.image}"/></p><p>${post.text}</p><span class="glyphicon glyphicon-remove"></span></div>`;
        } else {
            return `<div class="dashboard-post" data-id="${i}"><p>${post.title}</p><span class="glyphicon glyphicon-remove"></span></div>`;
        }

    }).join('');
    //console.log('postHtml : ', postsHtml);
    dashboardContent.html(postsHtml);
}

function displayErrors(data, target) {
    let post = document.createElement("div");
    post.classList.add("dashboard-post");
    let icon = document.createElement('span');
    icon.classList.add('glyphicon', 'glyphicon-remove');
    post.textContent = data.text;
    //let postHtml = `<div class="dashboard-post"><p>${data.text}</p></div>`;
    //console.log(target);

    target.appendChild(post);
    target.appendChild(icon);

}


function deletePostListener() {
    $('.delete-post').find('a').on('click', function(e) {
        e.preventDefault();
        let a = $(this);
        postElmt = e.target.parentNode.parentNode.parentNode;
        console.log(postElmt);
        $.ajax({
            url: a.attr('href'),
            method: 'GET'

        }).done(function(reponse) {
            console.log(reponse);
            $(".post-dashboard")[0].removeChild(postElmt);
        }).fail(function(jqxhr) {
            console.log(jqxhr.responseText);
        })
    });
}

function editPostListener() {
    $('.edit').find('a').on('click', function(e) {

        e.preventDefault();
        postElmt = e.target.parentNode.parentNode.parentNode;
        let postText = postElmt.childNodes[3].childNodes[1].textContent;
        postId = postElmt.dataset['postid'];
        $('#post-content').val(postText);
        $("#edit-modal").modal();

    });

}

dashboardContent.addEventListener('click', removeImagePreview);
document.querySelector("#file-upload").addEventListener('change', fileSelectionPreview);

// fetch opengraphpreview 

$("#content").on('focusout', function(e) {
    if ($("#content").val().match(/http/)) {
        let url = encodeURIComponent($("#content").val());
        fetch(URL + '/' + url + '?app_id=' + id)
            .then(response => response.json())
            .then(data => {
                if (Object.getOwnPropertyNames(data)[0] === "error") {
                    console.log('houuuuuuuuuura');
                    if (data.error.code === 101) {
                        var post = {
                            text: 'Une erreur est survenue lors de la connection a l\'API'
                        };
                        //console.log(postPannel[element].childNodes[3].childNodes[1]);
                        displayErrors(post, dashboardContent);
                    }
                } else {
                    var post = {
                        title: data.hybridGraph.title,
                        image: data.hybridGraph.image,
                        link: data.hybridGraph.url,
                        text: data.hybridGraph.description,
                        error: data.error
                    };

                    //console.log(post);
                    posts.push(post);
                    //console.log(posts);
                    fillDashboard(posts);
                    //storePost(posts);
                    posts = [];
                }
            }).catch(function(error) {
                console.log('ceci est une erreur :', error);
            });
    }

});

$("#post-form").submit('click', function(e) {
    e.preventDefault();
    let url = $(this)[0].action;
    console.log(url);

    $.ajax(url, {
        method: 'POST',
        header: {
            'X-CSRF-TOKEN': token
        },
        contentType: false,
        processData: false,
        enctype: 'multipart/form-data',
        data: new FormData(this)
    }).done(e, function(response) {
        $(".post-dashboard").empty();
        $(response).prependTo(".post-dashboard");
        editPostListener();
        deletePostListener();
        $('#content').val('');
    }).fail(function(err) {
        console.log('error');
    })
});

$('.delete-post').find('a').on('click', function(e) {
    e.preventDefault();

    let a = $(this);
    postElmt = e.target.parentNode.parentNode.parentNode;
    console.log(postElmt);

    $.ajax({
        url: a.attr('href'),
        method: 'GET'

    }).done(function(reponse) {
        console.log(reponse);
        $(".post-dashboard")[0].removeChild(postElmt);
    }).fail(function(jqxhr) {
        console.log(jqxhr.responseText);
    })

});

$('.edit').find('a').on('click', function(e) {

    e.preventDefault();
    postElmt = e.target.parentNode.parentNode.parentNode;
    let postText = postElmt.childNodes[3].childNodes[1].textContent;
    postId = postElmt.dataset['postid'];
    $('#post-content').val(postText);
    $("#edit-modal").modal();

});

// save modal content 

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