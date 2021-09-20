<template>
    <div class="container">
        <h3 class="text-center">Update {{book.name}}</h3>
        <div class="row">
            <div class="col-md-12">
                <form @submit.prevent="updatebook">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="book.name">
                    </div>
                    <div class="form-group">
                        <label>Isbn</label>
                        <input type="text" class="form-control" v-model="book.isbn">
                    </div>
                    <div class="form-group">
                        <label>Authors</label>
                        <input type="text" class="form-control" v-model="book.authors">
                    </div>
                    <div class="form-group">
                        <label>Number of Pages</label>
                        <input type="number" class="form-control" v-model="book.number_of_pages">
                    </div>
                    <div class="form-group">
                        <label>Publisher</label>
                        <input type="text" class="form-control" v-model="book.publisher">
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control" v-model="book.country">
                    </div>
                    <div class="form-group">
                        <label>Release Date</label>
                        <input type="date" class="form-control" v-model="book.release_date">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'update',
        data() {
            return {
                book: {}
            }
        },
        created() {
            axios
                .get(`http://localhost:8000/api/v1/books/${this.$route.params.id}`)
                .then((res) => {
                    // this.book = res.data.data[0];
                });
        },
        methods: {
            updatebook() {
                axios
                    .patch(`http://localhost:8000/api/v1/books/${this.$route.params.id}`, this.book)
                    .then((res) => {
                        this.$toaster.success(res.data.message)
                        this.$router.push({ name: 'home' });
                    }).catch((err) => {
                        console.log(err);
                    });
            }
        }
    }
</script>
