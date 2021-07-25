<template>
  <div class="container-fluid">
    <div class="fade-in">
      <div class="row">
        <div class="col-sm-12 col-xs-12">
          <div class="card">
            <div class="card-header">
              現在進行中のトレーサビリティ情報
            </div>
            <div class="card-body pt-2">
              <p class="text-center text-small mb-2 txt-paginate">2件進行中</p>
              <div class="container">

                <div class="row timeline_card">
                  <div class="timeline_block col-12 col-sm-12 col-xs-12">
                    <div class="row">
                      <div class="timeline_info col-8 col-sm-8 col-xs-8">
                        <div class="timeline_txt">
                          <div class="timeline_ttl">
                            <p>ZeniMoto-1111</p><button class="btn btn-sm btn-info" type="submit"> 更新 </button>
                          </div>
                          <p class="txt-paginate uuid">akhlwl8ecbahceGyvha5Ejvhdvjcdsc</p>
                          <div class="timeline_content">
                            <div class="row">
                              <div class="col-4 pr-0 col-sm-3"> 魚種 </div>
                              <div class="col-8 pl-0 col-sm-8"> タイ </div>
                            </div>
                          </div>
                          <div class="timeline_content">
                            <div class="row">
                              <div class="col-4 pr-0 col-sm-3"> 記入日時 </div>
                              <div class="col-8 pl-0 col-sm-8"> 2021/7/09 22時32分 </div>
                            </div>
                          </div>
                        </div>
                      </div>  
                      <div class="timeline_code col-4 col-sm-4 col-xs-4">
                        <img :src="data.QRCodeImg" width="50" height="50">
                        <a href="/restaurant/qrCode/11" class="text-info" style="font-size: 10px">ダウンロード</a>
                      </div>  
                    </div>
                    <div class="row">
                      <section class="time-line-box">
                        <div class="swiper-container text-center"> 
                          <div class="swiper-wrapper">
                            
                            <div class="swiper-slide active">
                              <span>生産者</span>
                              <div class="outer-circle">
                                <div class="inner-circle"></div>
                              </div>
                              <span>2021/7/12</span>
                            </div>

                            <div class="swiper-slide active">
                              <span>卸売業者</span>
                              <div class="outer-circle">
                                <div class="inner-circle"></div>
                              </div>
                              <span>2021/7/12</span>
                            </div>
                            
                            <div class="swiper-slide error current">
                              <span>飲食店</span>
                              <div class="outer-circle">
                                <div class="inner-circle"></div>
                              </div>
                              <span></span>
                            </div>

                             <div class="swiper-slide slide-looked">
                              <span>消費者</span>
                              <div class="outer-circle">
                                <div class="inner-circle"></div>
                              </div>
                              <span>2021/7/12</span>
                            </div>
                          </div>
                          <div class="swiper-pagination"></div>
                        </div>
                      </section>
                    </div>
                  </div>
                </div>

                <div class="row timeline_card">
                  <div class="timeline_block col-12 col-sm-12 col-xs-12">
                    <div class="row">
                      <div class="timeline_info col-8 col-sm-8 col-xs-8">
                        <div class="timeline_txt">
                          <div class="timeline_ttl">
                            <p>ZeniMoto-1112</p>
                            <button class="btn btn-sm btn-info" type="submit"> 詳細 </button>
                          </div>
                          <p class="txt-paginate uuid">akhlwl8ecbahceGyvha5Ejvhdvjcdsc</p>

                          <div class="timeline_content">
                            <div class="row">
                              <div class="col-4 pr-0 col-sm-3"> 魚種 </div>
                              <div class="col-8 pl-0 col-sm-8"> タイ </div>
                            </div>
                          </div>
                          <div class="timeline_content">
                            <div class="row">
                              <div class="col-4 pr-0 col-sm-3"> 記入日時 </div>
                              <div class="col-8 pl-0 col-sm-8"> 2021/7/09 22時32分 </div>
                            </div>
                          </div>

                        </div>
                      </div>  
                      <div class="timeline_code col-4 col-sm-4 col-xs-4">
                        <img :src="data.QRCodeImg" width="50" height="50">
                        <a href="/restaurant/qrCode/11">
                          <p class="text-info text-right" style="font-size: 10px">ダウンロード</p>
                        </a>
                      </div>  
                    </div>
                    <div class="row">
                      <section class="time-line-box">
                        <div class="swiper-container text-center"> 
                          <div class="swiper-wrapper">
                            
                            <div class="swiper-slide active">
                              <span>生産者</span>
                              <div class="outer-circle">
                                <div class="inner-circle"></div>
                              </div>
                              <span>2021/7/12</span>
                            </div>

                            <div class="swiper-slide active active current">
                              <span>卸売業者</span>
                              <div class="outer-circle">
                                <div class="inner-circle"></div>
                              </div>
                              <span></span>
                            </div>
                            
                            <div class="swiper-slide error">
                              <span>飲食店</span>
                              <div class="outer-circle">
                                <div class="inner-circle"></div>
                              </div>
                              <span></span>
                            </div>

                             <div class="swiper-slide">
                              <span>消費者</span>
                              <div class="outer-circle">
                                <div class="inner-circle"></div>
                              </div>
                              <span>2021/7/12</span>
                            </div>
                          </div>
                          <div class="swiper-pagination"></div>
                        </div>
                      </section>
                    </div>
                  </div>
                </div>

                <div class="row timeline_card">
                  <div class="timeline_block col-12 col-sm-12 col-xs-12">
                    <div class="row">
                      <div class="timeline_info col-8 col-sm-8 col-xs-8">
                        <div class="timeline_txt">
                          <div class="timeline_ttl">
                            <p>ZeniMoto-1114</p> 
                            <button class="btn btn-sm btn-info" type="submit"> 詳細 </button>
                          </div>
                          <p class="txt-paginate uuid">akhlwl8ecbahceGyvha5Ejvhdvjcdsc</p>

                          <div class="timeline_content">
                            <div class="row">
                              <div class="col-4 pr-0 col-sm-3"> 魚種 </div>
                              <div class="col-8 pl-0 col-sm-8"> タイ </div>
                            </div>
                          </div>
                          
                          <div class="timeline_content">
                            <div class="row">
                              <div class="col-4 pr-0 col-sm-3"> 記入日時 </div>
                              <div class="col-8 pl-0 col-sm-8"> 2021/7/09 22時32分 </div>
                            </div>
                          </div>

                        </div>
                      </div>  
                      <div class="timeline_code col-4 col-sm-4 col-xs-4">
                        <img :src="data.QRCodeImg" width="50" height="50">
                        <a href="/restaurant/qrCode/11">
                          <p class="text-info text-right" style="font-size: 10px">ダウンロード</p>
                        </a>
                      </div>  
                    </div>
                    <div class="row">
                      <section class="time-line-box">
                        <div class="swiper-container text-center"> 
                          <div class="swiper-wrapper">
                            
                            <div class="swiper-slide active">
                              <span>生産者</span>
                              <div class="outer-circle">
                                <div class="inner-circle"></div>
                              </div>
                              <span>2021/7/12</span>
                            </div>

                            <div class="swiper-slide active">
                              <span>卸売業者</span>
                              <div class="outer-circle">
                                <div class="inner-circle"></div>
                              </div>
                              <span>2021/7/15</span>
                            </div>
                            
                            <div class="swiper-slide active error">
                              <span>飲食店</span>
                              <div class="outer-circle">
                                <div class="inner-circle"></div>
                              </div>
                              <span>2021/7/19</span>
                            </div>

                             <div class="swiper-slide active current">
                              <span>消費者</span>
                              <div class="outer-circle">
                                <div class="inner-circle"></div>
                              </div>
                              <span>2021/7/12</span>
                            </div>
                          </div>
                          <div class="swiper-pagination"></div>
                        </div>
                      </section>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 text-center">
          <a class="a-link" href="#">過去のトレーサビリティ履歴</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        baseUrl: Laravel.baseUrl,
      }
    },
    props: ['data']
  }
</script>
