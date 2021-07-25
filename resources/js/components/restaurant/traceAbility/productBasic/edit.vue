<template>
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card product-basic edit">
          <div class="card-header">
            商品情報
            <a class="float-right collapse-toggle" data-toggle="collapse" href="#collapseProductBasic" aria-expanded="true" aria-controls="collapseProductBasic">
              <!-- TODO トグルの開閉に合わせて180度回転 -->
              <img src="/assets/img/arrow-down.svg" alt="ARROW-DOWN-ICON">
            </a>
          </div>
          <!-- TODO トグルが開閉しないのを直す -->
          <div class="collapse show" id="collapseProductBasic">
            <div class="card-body">
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>商品写真（任意）</label>
                          <div>
                            <div class="upload-area uploaded"
                              v-for="(fileList, index) in files"
                              :key="index"
                            >
                              <div class="wrapper">
                                <img class="delete"
                                  src="/assets/img/delete-btn.svg"
                                  alt="DELETE-BUTTON"
                                  @click="deleteFile(index)"
                                >
                                <img :src="fileList[0].path" multiple alt="UPLOADS-FILES">
                              </div>
                            </div>
                            <div class="upload-area frame"
                              @dragenter="dragEnter"
                              @dragleave="dragLeave"
                              @dragover.prevent
                              @drop.prevent="dropFile"
                              @click="openBrowse"
                              :class="{enter: isEnter, 'd-none': isDisplay}"
                            >
                              <input
                                type="file"
                                ref="file_upload_btn"
                                class="d-none"
                                name="file"
                                @change="inputFile"
                              >
                            </div>
                          </div>
                          <div class="upload-area-attention">
                            <span>漁獲後の状態の画像を選択してください。3MB以下のJPEG/PNG形式を選択してください。選択できる最大画像数は2つまでです。</span>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>魚種<span class="text-danger">*</span></label>

                          <!-- TODO 入力の際のconsole.logのエラーを減らしたい -->
                          <suggest-select
                            :options="kinds"
                            label="魚種を入力または選択してください"
                          ></suggest-select>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>目方（kg）<span class="text-danger">*</span></label>
                          <input class="form-control" min="0" max="1000" type="number" value="">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>品質<span class="text-danger">*</span></label>
                          <select class="form-control" id="ccyear">
                              <option>-- 選択してください --</option>
                              <option>★☆☆☆☆</option>
                              <option>★★☆☆☆</option>
                              <option>★★★☆☆</option>
                              <option>★★★★☆</option>
                              <option>★★★★★</option>
                          </select>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import SuggestSelect from "../../../common/suggestSelect.vue";

// TODO 保存してからPATHを取得
function serverFileUpload( file )
{
  let form = new FormData();
  form.append('file', file);
  axios.post('/api/file/store', form).then(response => {
      console.log(response.data);
  }).catch(error => {
      console.log(error);
  });
  file[0].path = '/uploads/users/生産者サンプル.jpg';
}

// TODO 削除してから非表示
function serverFileDelete( path )
{
  let form = new FormData();
  form.append('path', path);
  axios.delete('/api/file/', form).then(response => {
      console.log(response.data);
  }).catch(error => {
      console.log(error);
  });
}

export default {
  components: {
    SuggestSelect
  },
  data: function () {
    return {
      isEnter: false,
      attachablePhotoNum: 2, // TODO 生産者の時:2, それ以外:1
      isDisplay: false,
      files: [],
      kinds: [
        'タイ',
        'タラバガニ',
        'タラ',
      ]
    }
  },
  methods: {
      dragEnter() {
        this.isEnter = true;
      },
      dragLeave() {
        this.isEnter = false;
      },
      dropFile(e) {
        let file = e.dataTransfer.files;
        serverFileUpload( file );
        this.files.push(file);
        this.isEnter = false;
        if ( this.files.length >= this.attachablePhotoNum ) this.isDisplay = true;
      },
      openBrowse() {

        // 同じファイルはブラウズの場合2個以上アップできない
        let targetElement = this.$refs.file_upload_btn;
        targetElement.click();
        return false;
      },
      inputFile(e) {
        let file = e.target.files;
        serverFileUpload( file );
        this.files.push(file);
        this.isEnter = false;
        if ( this.files.length >= this.attachablePhotoNum ) this.isDisplay = true;
      },
      deleteFile(index) {

        // TODO ブラウズ立ち上げ後キャンセルをするとpathなしのエラーになる
        let path = this.files[index][0].path;
        serverFileDelete( path );
        this.files.splice(index, 1);
        if ( this.files.length < this.attachablePhotoNum ) this.isDisplay = false;
      }
  },
  props: {}
}
</script>
