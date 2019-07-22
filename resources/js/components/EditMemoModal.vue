<template>
    <div class="modal fade" id="editMemoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">メモ編集</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" v-if="memo">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" v-model="form.title">
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" v-model="form.content" rows="8"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="content">Image</label>
                        <croppa v-model="form.imagePicker"
                                :width="400"
                                :height="400"
                                placeholder="画像ファイルを選択"
                                placeholder-color="#fff"
                                :placeholder-font-size="16"></croppa>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="close">キャンセル</button>
                    <button type="button" class="btn btn-primary" @click="updateButtonClicked">更新</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Croppa from 'vue-croppa';
    export default {
        name: "EditMemoModal",
        components: {croppa: Croppa.component},
        data: function () {
            return {
                form: {
                    title: null,
                    content: null,
                    imagePicker: {}
                },
                memo: null
            }
        },
        methods: {
            open: function (memo) {
                this.memo = memo;
                this.form.title = memo.attributes.title;
                this.form.content = memo.attributes.content;
                $("#editMemoModal").modal('show');
            },
            close: function () {
                this.form.title = null;
                this.form.content = null;
                $("#editMemoModal").modal('hide');
            },
            updateButtonClicked: async function () {
                let formData = new FormData();
                let image = await this.form.imagePicker.promisedBlob('image/jpeg', 0.8);

                if (image) {
                    formData.append('image', image);
                }
                if (this.form.title) {
                    formData.append('title', this.form.title);
                }
                if (this.form.content) {
                    formData.append('content', this.form.content);
                }

                formData.append('_method', 'PATCH');

                let config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                };

                axios.post(this.memo ? this.memo.links.self : "", formData, config)
                    .then((response) => {
                        this.close();
                        this.$emit('memo-has-updated', response.data.data)
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>