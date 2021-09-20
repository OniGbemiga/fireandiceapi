<template>
    <div>
        <h2 class="text-center">List of first {{limit}} Books</h2>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name of Book</th>
                <th>Isbn</th>
                <th>Authors</th>
                <th>Number of Pages</th>
                <th>Publisher</th>
                <th>Country</th>
                <th>Release Date</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="book in limitBooksCount" :key="book.id">
                <td>{{ book.id }}</td>
                <td>{{ book.name }}</td>
                <td>{{ book.isbn }}</td>
                <td>{{ (book.authors).join(',') }}</td>
                <td>{{ book.number_of_pages }}</td>
                <td>{{ book.publisher }}</td>
                <td>{{ book.country }}</td>
                <td>{{ book.release_date }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'update', params: { id: book.id }}" class="btn btn-success">Update</router-link>
                        <button class="btn btn-danger" @click="deleteBook(book.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'Home',
    data() {
        return {
            books: [],
            limit: 10,
            showTop: false
        }
    },
    computed: {
        limitBooksCount(){
            return this.limit ? this.books.slice(0,this.limit) : this.books
        }
    },
    mounted() {
        axios
        .get('http://localhost:8000/api/v1/books')
        .then(response => {
            this.books = response.data.data;
        }).catch((err) => {
            console.log(err);
        });
    },
    methods: {
        deleteBook(id){
            axios
                .delete(`http://localhost:8000/api/v1/books/${id}`)
                .then(response => {
                    let i = this.books.map(data => data.id).indexOf(id);
                    this.books.splice(i, 1);
                    this.$toaster.success(response.data.message)
                });
        }
    },

}
</script>
