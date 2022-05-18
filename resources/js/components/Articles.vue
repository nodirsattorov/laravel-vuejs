<template>
    <h2>
        Articles
    </h2>
    <form @submit.prevent="addArticle()" class="mb-3">
        <div class="form-group">
            <input type="text" placeholder="Title..." class="form-control" v-model="article.title">
        </div>
        <div class="form-group">
            <textarea placeholder="Body..." class="form-control" v-model="article.body"></textarea>
        </div>
        <button type="submit" class="btn btn-light btn-block">Save</button>
    </form>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li 
            class="page-item"
            :class="[{disabled: !pagination.prev_page_url}]"
            @click="fetchArticles(pagination.prev_page_url)" 
            ><a class="page-link" href="#">Previous</a></li>
            <li class="page-item disabled"><a class="page-link " href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
            <li 
            class="page-item"
            :class="[{disabled: !pagination.next_page_url}]"
            @click="fetchArticles(pagination.next_page_url)" 
            ><a class="page-link" href="#">Next </a></li>
           
        </ul>
    </nav>
    <div class="card card-body mb-2" v-for="article in articles" :key="article.id">
        <h2>{{article.title}}</h2>
        <p>{{ article.body }}</p>
        
        <button @click="editArticle(article)" class="btn btn-warning mb-2">EDIT</button>
        <button @click="deleteArticle(article.id)" class="btn btn-danger">Delete</button>
    </div>
</template>

<script>
export default{
    name: 'Articles',
    data(){
        return {
            articles: [],
            article: {
                id: '',
                article_id: '',
                title: '',
                body: '',
            },
            article_id: '',
            pagination: {},
            edit: false
        }
    },
    created(){
        this.fetchArticles();
    },
    methods: {
        
        fetchArticles(page_url){
            let vm = this;
            page_url = page_url || 'api/articles'
            fetch(page_url)
            .then(res => res.json())
            .then(res => {
                this.articles = res.data;
                vm.makePagination(res.links, res.meta);
            })
            .catch(err => console.log(err));
        },  
        makePagination(links, meta){
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                prev_page_url: links.prev,
                next_page_url: links.next
            }
            this.pagination = pagination;
        },
        deleteArticle(id){
            if(confirm('Are you suer?')){
                fetch(`api/article/${id}`, {
                    method: 'DELETE'
                })
                .then(res => res.json())
                .then(data => {
                    this.fetchArticles();
                    alert('Article deleted')
                    
                })
                .catch(err => console.log(err));
            }
        },
        addArticle(){
            console.log(this.article);
            if(this.edit === false){
                fetch('api/article',{
                    method: "POST",
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify(this.article)
                })
                .then(res => res.json())
                .then(data => {
                    this.article.title = '';
                    this.article.body = '';
                    this.fetchArticles();
                    alert('Article added');
                })
                .catch(err => console.log(err));
            }
            else {
                fetch('api/article',{
                    method: "PUT",
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify(this.article)
                })
                .then(res => res.json())
                .then(data => {
                    this.article.title = '';
                    this.article.body = '';
                    this.fetchArticles();
                    alert('Article UPDATED');
                })
                .catch(err => console.log(err));
            }
        },
        editArticle(article){
            this.edit = true;
            this.article.id = article.id;
            this.article.article_id = article.id;
            this.article.title = article.title;
            this.article.body = article.body;
            
        }
    }
}
</script>