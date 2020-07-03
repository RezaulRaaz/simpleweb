<template>
<div>
    <br>
    <br>
    <br>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Create Post or Video Post
        </div>
        <div class="card-body">
            <form enctype="multipart/form-data" method="post" @submit.prevent="submitForm" >
             <div class="row">
                 <div class="col-lg-6">
                     <div class="form-group">
                         <label for="exampleInputEmail1">*Title</label>
                         <input type="text" class="form-control" v-model="title" id="exampleInputEmail1" aria-describedby="emailHelp">
                     </div>
                     <div class="form-group">
                         <label for="exampleFormControlSelect1">*Select Type</label>
                         <select v-model="selectType" class="form-control" id="exampleFormControlSelect1">
                             <option v-for="type in types" selected >{{type}}</option>
                         </select>
                     </div>
                     <div class="form-group" v-show="selectType=='Video'">
                         <label for="link">*Video Url</label>
                         <input type="text"  v-model="ylink" class="form-control" id="link" placeholder="Please Enter Youtube Video Url" aria-describedby="emailHelp">

                     </div>
                     <div class="form-group">
                         <label for="exampleFormControlFile1">*Upload Tumbnil/ Post Image</label>
                         <input  @change="imageSelected" type="file" class="form-control-file" id="exampleFormControlFile1">
                     </div>
                     <div class="form-group">
                         <label for="exampleFormControlTextarea1">Brief</label>
                         <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="desc"></textarea>
                     </div>
                     <div class="form-group">
                         <label for="section">*Select Section</label>
                         <select v-model="selectSection" class="form-control" id="section">
                             <option v-for="section in sections">{{section}}</option>
                         </select>
                     </div>
                     <div class="form-group form-check">
                         <input type="checkbox" v-model="publish" value="1" class="form-check-input" id="exampleCheck1">
                         <label class="form-check-label" for="exampleCheck1">Publish</label>
                     </div>
                     <button type="submit" class="btn btn-dark">Submit</button>
                 </div>
                 <div class="col-lg-6">
                     <h3>{{datacollect.ftitle}}</h3>
                     <h3>{{datacollect.ftype}}</h3>
                     <iframe v-show="datacollect.flink !=''" width="560" height="315" :src="datacollect.flink" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <div v-if="imagepreview">
                            <img :src="imagepreview" class="figure-img img-fluid" style="max-height: 150px">
                        </div>
                 </div>

             </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
    import getYouTubeID from 'get-youtube-id';
    export default {
        name: "Post",
        data(){
            return{
                title:'',
                types:['Video','Post'],
                selectType:'',
                sections:['Section 1','Section 2'],
                selectSection:'',
                ylink:'',
                desc:'',
                publish:'',
                idLink:'',
                image:null,
                imagepreview:null,
                datacollect:{
                    ftitle:'',
                    ftype:'',
                    flink:'',
                }

            }
        },

        mounted(){

        },
        methods:{
            imageSelected(e) {
               this.image =e.target.files[0];
               let reader = new FileReader();
               reader.readAsDataURL(this.image);
               reader.onload = e =>{
                   this.imagepreview =e.target.result;
               };

            },
            submitForm() {
                var link = this.ylink.toString();
                var id = getYouTubeID(link);
                var embedlink= 'https://www.youtube.com/embed/'+id;

                this.datacollect.flink=embedlink;

                let data= new FormData();
                data.append('image',this.image);
                data.append('title',this.title);
                data.append('embed',this.datacollect.flink);
                data.append('type',this.selectType);
                data.append('section',this.selectSection);
                data.append('desc',this.desc);
                data.append('publish',this.publish);
                axios.post('/post/data',data)
                    .then((response)=>{

                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            }
        },
        computed:{

        },

    }
</script>

<style scoped>

</style>
