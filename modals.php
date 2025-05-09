<!-- Modal -->
<div class="modal fade" id="movieModal" tabindex="-1" aria-labelledby="movieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content dark-bg" style="position: relative; overflow: hidden; border: none;">
            
            <!-- ปุ่มปิด -->
            <button type="button" id="close-btn" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                style="position: absolute; top: 15px; right: 15px; z-index: 10;"></button>

            <!-- พื้นหลังเบลอ -->
            <div class="modalBg" id="media-bg"></div>

            <div class="row justify-content-center align-items-center" style="position: relative; z-index: 3;">
                <div class="col-md-5 text-center">
                    <!-- รูปโปสเตอร์ -->
                    <img id="media-poster"
                        style="width: 300px; height: 400px; object-fit: cover; margin: 20px auto; display: block;
                            border-radius: 12px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);">
                </div>
                <div class="col-md-7 text-center">
                    <h1 id="media-title"></h1>
                    <p class="m-0" id="duration-p"></p>
                    <!-- ปุ่ม Play -->
                    <button id="play-btn" class="btn btn-warning m-4 shadow" style="width: 180px; height: 50px;" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                            <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                        </svg>
                    </button>

                    <!-- ปุ่ม Watchlist -->
                    <button id="watchlist-btn2" class="btn btn-light m-4 shadow " style="width: 180px; height: 50px;" >
                        <span id="watchlist-icon2"></span>
                        รายการของฉัน
                    </button>
                    <p id="continue-p"></p>
                </div>
            </div>

            <!-- ข้อมูลใน modal -->
            <div class="modal-body" style="position: relative; z-index: 3; color: white;">
                <div class="row justify-content-center mb-3">
                    <div class="col-md-7" style="padding-left: 50px; padding-right: 50px;">
                        <p id="media-desc">คำอธิบาย</p>
                    </div>

                    <div class="col-md-5" style="padding-left: 50px; padding-right: 50px;">
                        <div class="row mb-3">
                            <h6 class="w-auto text-center" style="margin-right: 10px; padding-top: 5px;" id="media-release"></h6>
                            <h6 id="media-rate" class="p-1 text-center w-auto" style="border: 1px solid white;"></h6>
                        </div>
                        <div class="row">
                            <p id="media-genre">ประเภท:</p>
                            <p id="media-director">ผู้กำกับ: </p>
                            <p id="media-actor">นักแสดง: </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>