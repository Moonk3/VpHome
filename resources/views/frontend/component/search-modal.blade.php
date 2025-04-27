<div id="search-modal" class="uk-modal">
    <div class="uk-modal-dialog">
        <div class="uk-container-1320 uk-container-center">
            <a class="search-close uk-modal-close">×</a>
            <div class="search-container">
                <form action="{{ write_url('tim-kiem') }}">
                    <div class="search-row">
                        <div class="category-select">
                            <select class="form-row uk-width-1-1 nice-select">
                                <option value="">Tất cả các danh mục</option>
                                @if(isset($quick_search) && !is_null($quick_search))
                                    @foreach($quick_search->object as $k => $v)
                                        @php
                                            $name = $v->languages->first()->pivot->name;
                                            $canonical = write_url($v->languages->first()->pivot->canonical);
                                        @endphp
                                        <option value="">{{ $name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="search-input">
                            <input type="text" name="keyword" class="uk-width-1-1" placeholder="Nhập từ khóa...">
                        </div>
                        <button type="submit" class="uk-button uk-button-primary">
                            <img src="/frontend/resources/img/search.svg" alt="">
                        </button>
                    </div>
                </form>
                <div class="quick-search mb40">
                    <span class="quick-search-label">Tìm kiếm nhanh :</span>
                    @if(isset($quick_search) && !is_null($quick_search))
                        @foreach($quick_search->object as $k => $v)
                            @php
                                $name = $v->languages->first()->pivot->name;
                                $canonical = write_url($v->languages->first()->pivot->canonical);
                            @endphp
                            <a href="{{ $canonical }}" class="quick-search-tag">{{ $name }}</a>
                        @endforeach
                    @endif
                </div>
                @if(isset($also_like) && !is_null($also_like))
                    <div class="panel-also-like">
                        <div class="panel-head mb20">
                            <h2 class="heading-1"><span>{{ $also_like->name }}</span></h2>
                        </div>
                        <div class="panel-body">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach($also_like->object as $keyAttr => $valAttr)
                                        <div class="swiper-slide">
                                            @php
                                                $name = $valAttr->languages->first()->pivot->name;
                                                $image = image($valAttr->image , $name);
                                                $canonical = write_url($valAttr->languages->first()->pivot->canonical);
                                                $price = getPrice($valAttr);
                                            @endphp
                                            <div class="also-like-item">
                                                <div class="image-content mb10">
                                                    <a href="{{ $canonical }}" class="img img-scaledown img-zoomin">{!! $image !!}</a>
                                                </div>
                                                <div class="text-content">
                                                    <h5 class="heading-4"><a href="{{ $canonical }}">{{ $name }}</a></h5>
                                                    <div class="product-price">
                                                        {!! $price['html'] !!}
                                                        @if($price['percent'] > 0)
                                                            <div class="price-old">{{ convert_price($price['price'], true); }}đ</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<style>
    .search-row {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    .category-select {
        min-width: 200px;
        padding-right: 20px;
        position: relative;
    }
    .category-select::before{
        content: "";
        display: block;
        position: absolute;
        border-right: 1px solid #666;
        opacity: 0.6;
        right: 0;
        width: 100%;
        height: 30px;
        top: 50%;
        transform: translate(0, -50%);
    }
    .search-input {
        flex-grow: 1;
    }
    .quick-search {
        margin-top: 10px;
    }
    .quick-search-label {
        color: #666;
        margin-right: 15px;
    }
    .quick-search-tag {
        display: inline-block;
        margin-right: 10px;
        padding: 5px 15px;
        background: #f8f8f8;
        border-radius: 20px;
        color: #333;
        text-decoration: none;
        transition: background 0.3s;
    }
    .quick-search-tag:hover {
        background: #CC0D39;
        color:#fff;
        text-decoration: none;
        transition: 0.2s all ease;
    }
    .search-close {
        position: absolute;
        top: 10px;
        right: 10px;
        color: #999;
        font-size: 32px;
        cursor: pointer;
    }
    .uk-modal-dialog {
        width: 90%;
        max-width: 1200px;
    }
    #search-modal .uk-modal-dialog{
        padding: 50px 0 !important;
        margin: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }
    #search-modal input[name="keyword"], #search-modal select{
        border: none;
        outline: none;
    }
    #search-modal input[name="keyword"]{
        padding: 10px 20px;
        height: 45px;
    }
    #search-modal .search-row{
        padding-bottom: 8px;
        border-bottom: 2px solid #000;
    }
    .also-like-item .image , .also-like-item img{
        border-radius: 10px;
    }
</style>