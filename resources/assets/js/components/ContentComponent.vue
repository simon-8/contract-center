<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Content Component</div>

                    <div class="panel-body">
                        Content ID
                        <h4>{{ id }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                id: 0
            }
        },
        mounted() {
            this.id = this.$route.params.id;
            console.log('Component mounted.')
        }
    }
</script>
