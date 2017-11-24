console.log('dashboard');

const body = document.body;
const input = $("#dashboard-input");
const overlay = $(".overlay");

function showFloat() {
    body.classList.add('show-float');
}

function closeFloat() {
    if (body.classList.contains('show-float')) {
        body.classList.remove('show-float');
    }

}

input.addEventListener('focusin', showFloat);

overlay.addEventListener('click', closeFloat);



const dashboardList = document.querySelector(".dashboard-list");
const dashboardForm = document.querySelector(".dashboard-form");
const dashboardInput = dashboardForm.querySelector('input[type=text]');
var posts = JSON.parse(localStorage.getItem('posts')) || [];
const URL = 'https://opengraph.io/api/1.0/site';
const id = '59fca8d730b7020b00f62836';




//console.log(posts);
fillDashboardList(posts);

function createPost(e) {
    //e.preventDefault();
    if (dashboardInput.value.match(/http/)) {
        alert('ok');
        var url = encodeURIComponent(dashboardInput.value);
        fetch(URL + '/' + url + '?app_id=' + id)
            .then(response => response.json())
            .then(data => {
                var post = {
                    title: data.hybridGraph.title,
                    image: data.hybridGraph.image,
                    link: data.hybridGraph.url
                };
                console.log(post);
                posts.push(post);
                fillDashboardList(posts);
                storePost(posts);
                dashboardForm.reset();

            });
    } else {
        var title = dashboardInput.value;
        var post = {
            title: title
        };
        posts.push(post);
        fillDashboardList(posts);
        storePost(posts);
        dashboardForm.reset();
    }

}

function fillDashboardList(posts = []) {

    var postsHtml = posts.map(function(post, i) {
        if (post.link || post.image) {
            return `<div class="dashboard-post" data-id="${i}"><p><a href="${post.link}">${post.title}</a></p><p><img class="img-responsive" src="${post.image}"/></p><span class="glyphicon glyphicon-remove"></span></div>`;
        } else {
            return `<div class="dashboard-post" data-id="${i}"><p>${post.title}</p><span class="glyphicon glyphicon-remove"></span></div>`;
        }

    }).join('');

    dashboardList.innerHTML = postsHtml;
}

function storePost(posts = []) {
    localStorage.setItem('posts', JSON.stringify(posts));
}

function removePost(e) {
    if (!e.target.matches('.glyphicon-remove')) {
        return;
    }
    console.log('hello');
    var index = e.target.parentNode.dataset.id;
    posts.splice(index, 1);
    fillDashboardList(posts);
    storePost(posts);

}

dashboardList.addEventListener('click', removePost);

dashboardForm.addEventListener('submit', createPost);