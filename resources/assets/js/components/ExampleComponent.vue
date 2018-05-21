<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        I'm an example component 2222!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            getData () {
                this.$http.get('http://blog.cc/api/article').then(function(res) {
                    console.log(1)
                    console.log(res)
                }).catch(function(res) {
                    console.log(2)
                    console.log(res)
                })
            }
        },
        mounted() {
            this.getData();
            console.log('Component mounted.')
        }
    }
</script>
