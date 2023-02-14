<template>
    <div class="container-fluid">
        <div class="card mt-5 p-5">
            <h3>ADD ANNOUNCEMENT</h3>
            <div class="row mt-5">
                <form id="add_announcement_form" enctype='multipart/form-data'>
                    <div class="col-md-6">
                        <label for="">Type</label>
                        <select name="type_id" id="" class="form-control">
                            <option value="">Select announcement category</option>
                            <option :value="row.id" v-for="row in types" :key="row.id">{{row.name}}</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="">Desc</label>
                        <textarea name="desc" id="" cols="20" rows="10" class="form-control" style="resize:none;">
                        </textarea>
                    </div>
                    <div class="col-md-12 row">
                        <div class="col-md-6 mt-3">
                            <label for="">Image</label>
                            <input class="form-control" type="file" name="image">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="">Attachment</label>
                            <input class="form-control" type="file" name="attachment">
                        </div>
                    </div>
                    <div class="col-md-12 row" id="image_div" style="display:none;">
                        <div class="col-md-6">
                            <img src="" id="image">
                        </div>
                    </div>
                    <div class="mt-3">
                        <a class="btn btn-default" v-on:click="submit()" style="float:right;background-color:#74c4d8;color:white;font-weight: bold;">SUBMIT</a>
                        <a class="btn btn-default" href="http://127.0.0.1:8000/Announcement" style="margin-right:5px;float:right;background-color:lightgrey;color:white;font-weight: bold;">BACK</a>
                    </div>
                    <!-- <input type="text" name="announcement_id" :value="0" hidden> -->
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { error_response, success_response, warning_response } from '../../../../vue-laravel/resources/js/sweetalert';
var header = { headers: { 'Content-Type': 'multipart/form-data' } };
    export default {
        data() {
            return {
                types: null,
            }
        },
        mounted(){
            fetch("http://127.0.0.1:8000/api/Announcement/get_announcement_types")
            .then(async (response) => {
                var data = await response.json();
                if(data.status == "Success"){
                    this.types = data.data.data;
                }else{
                    error_response("error");
                }
            })
            .catch((err) =>{
                throw err
            })
        },
        methods: {
            submit(){
                var form = document.getElementById("add_announcement_form");
                var formdata = new FormData(form);

                axios.post("http://127.0.0.1:8000/api/Announcement/manage", formdata, header)
                .then((response) => {
                    if(response.data.status == "Success"){
                        success_response("Successfully added announcement!", true, "Announcement")
                    }else{
                        warning_response(response.data.message[0]);
                    }
                })
                .catch((err) => {
                    error_response(err)
                })
            }
        }
    }
</script>
