@extends('storefront.layout.theme6')
@section('page-title')
    {{ __('Home') }}
@endsection

@php
$imgpath = \App\Models\Utility::get_file('uploads/');
$s_logo = \App\Models\Utility::get_file('uploads/store_logo/');
$coverImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
$productImg = \App\Models\Utility::get_file('uploads/product_image/');
$testimonialImg = \App\Models\Utility::get_file('uploads/testimonial_image/');
$default = \App\Models\Utility::get_file('uploads/theme6/header/brand_logo.png');
$theme_name = $store->theme_dir;
@endphp

@section('content')
<main>
    @foreach ($pixelScript as $script)
        <?= $script; ?>
    @endforeach
    
    @foreach ($getStoreThemeSetting as $ThemeSetting)
        @if (isset($ThemeSetting['section_name']) && $ThemeSetting['section_name'] == 'Home-Header' && $ThemeSetting['section_enable'] == 'on')
            @php
                $homepage_header_sub_title_key = array_search('Sub Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_title_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_Sub_text_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_Button_key = array_search('Button', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_bckground_Image_key = array_search('Background Image', array_column($ThemeSetting['inner-list'], 'field_name'));

                if(isset($getStoreThemeSetting[0]['homepage-header-sub-title'])){
                    $homepage_header_sub_title = $getStoreThemeSetting[0]['homepage-header-sub-title'][0] ?? $ThemeSetting['inner-list'][$homepage_header_sub_title_key]['field_default_text'];

                    $homepage_header_title = $getStoreThemeSetting[0]['homepage-header-title'][0] ?? $ThemeSetting['inner-list'][$homepage_header_title_key]['field_default_text'];

                    $homepage_header_Sub_text = $getStoreThemeSetting[0]['homepage-sub-text'][0] ?? $ThemeSetting['inner-list'][$homepage_header_Sub_text_key]['field_default_text'];
                    
                    $homepage_header_Button = $getStoreThemeSetting[0]['homepage-header-button'][0] ?? $ThemeSetting['inner-list'][$homepage_header_Button_key]['field_default_text'];
                    
                    $homepage_header_bckground_Image = $getStoreThemeSetting[0]['homepage-header-bg-image'][0]['image'] ?? $ThemeSetting['inner-list'][$homepage_header_bckground_Image_key]['field_default_text'];
                } else {
                    $homepage_header_sub_title = $ThemeSetting['inner-list'][$homepage_header_sub_title_key]['field_default_text'];

                    $homepage_header_title = $ThemeSetting['inner-list'][$homepage_header_title_key]['field_default_text'];
                    
                    $homepage_header_Sub_text = $ThemeSetting['inner-list'][$homepage_header_Sub_text_key]['field_default_text'];
                    
                    $homepage_header_Button = $ThemeSetting['inner-list'][$homepage_header_Button_key]['field_default_text'];
                    
                    $homepage_header_bckground_Image = $ThemeSetting['inner-list'][$homepage_header_bckground_Image_key]['field_default_text'];
                }
            @endphp
            <section class="main-banner-sec" style="background-image: url({{ $imgpath . $homepage_header_bckground_Image }});">
                <div class="banner-bg-wrp">
                    <svg class="banner-bg-img banner-bg-one" xmlns="http://www.w3.org/2000/svg" width="147" height="165" viewBox="0 0 147 165" fill="none">
                        <path d="M109.893 2.88058C109.998 3.05074 110.103 3.22089 110.155 3.30597C98.2348 16.5463 91.9095 34.088 90.7666 51.8372C89.4261 72.882 96.1107 93.7889 108.168 111.025C111.766 116.089 115.843 120.976 120.187 125.345C124.289 129.511 129.336 135.209 135.039 137.211C135.367 137.361 135.372 136.417 135.267 136.247C131.138 131.275 125.412 127.524 120.825 122.953C116.028 118.041 111.741 112.814 107.945 107.048C100.983 96.5387 95.7876 84.7028 93.4474 72.1612C95.6922 78.6497 99.6587 84.3099 104.253 89.4645C107.889 93.4481 111.813 97.1364 115.619 101.015C119.426 104.893 122.721 109.087 126.187 113.176C126.207 113.399 126.312 113.569 126.385 113.877C129.388 123.305 133.192 133.65 139.18 141.822C137.076 140.889 134.939 140.093 132.802 139.298C128.01 137.439 123.133 135.632 118.458 133.583C112.472 130.933 106.572 128.231 100.821 125.201C97.9059 121.242 94.4801 117.599 91.7674 113.397C89.1923 109.229 86.905 104.765 85.2333 100.155C84.9304 99.2844 84.6276 98.4136 84.3248 97.5428L84.2723 97.4578C84.1471 97.0649 84.022 96.672 83.8969 96.2792C80.288 85.1088 79.3642 73.3378 81.2381 61.7194L81.2706 61.5817C81.4532 61.1163 80.9602 60.1279 80.6274 60.9211C80.5424 60.9737 80.5949 61.0587 80.5098 61.1113C80.4248 61.1638 80.3922 61.3015 80.3597 61.4391C76.4964 70.4077 72.8834 80.1619 74.0924 90.1112C75.4216 101.397 83.5395 109.782 92.2179 116.41C93.6368 118.707 95.2985 121.207 97.1954 123.327C95.0183 122.085 92.8412 120.844 90.6966 119.466C82.4662 114.324 75.3142 107.693 67.319 102.17C60.8978 97.6738 52.8401 93.9532 44.8702 95.7026C44.2547 95.8478 44.042 97.9773 44.7102 97.9172C63.9632 97.3084 77.6492 113.185 92.5961 123.112C99.9481 127.973 107.718 131.989 115.606 135.815C114.302 135.798 113.083 135.728 111.832 135.795C108.196 135.808 104.528 135.958 100.944 136.056C101.042 135.643 100.917 135.25 100.727 135.132C81.8061 126.956 61.5092 118.453 40.4596 122.052C35.9929 122.813 31.6714 124.19 27.5802 126.129C26.9646 126.274 26.349 126.42 25.6484 126.617C25.4782 126.722 25.4132 126.998 25.3481 127.273C21.5847 129.363 18.1891 132.048 15.1614 135.328C12.9119 137.776 10.9576 140.511 9.27867 143.311C9.02343 143.469 8.76822 143.626 8.48046 143.922C8.31031 144.027 8.23274 144.662 8.508 144.727C5.5229 149.98 3.10837 155.585 0.969075 161.256C0.904025 161.531 0.793939 162.304 1.20683 162.402C35.6368 168.286 74.5505 160.117 101.72 137.692C101.805 137.64 101.753 137.555 101.838 137.502C108.009 137.217 114.179 136.931 120.162 138.054C124.201 140.026 127.985 142.156 131.939 144.18C136.083 146.322 140.424 149.164 145.214 149.497C146.347 149.619 146.553 146.907 145.877 146.384C144.506 145.115 142.932 144.089 141.325 143.201C139.906 140.904 138.487 138.607 137.068 136.31C135.149 124.449 136.472 112.7 136.524 100.796C136.541 95.4964 136.336 90.2165 135.908 84.9566C135.953 84.4586 135.965 84.0982 136.01 83.6003C135.99 83.3776 135.885 83.2074 135.833 83.1223C135.312 77.3319 134.568 71.5615 133.655 65.8963C132.821 61.1218 131.765 56.3674 130.624 51.6655C130.571 51.5804 130.657 51.5279 130.604 51.4428C130.551 51.3578 130.584 51.2201 130.531 51.135C127.853 40.33 124.252 29.7427 119.918 19.4907C119.898 19.268 119.93 19.1304 119.825 18.9603C119.753 18.6525 119.615 18.6199 119.582 18.7576C117.478 13.828 115.203 9.00363 112.758 4.2843C113.103 3.1307 112.955 0.988698 112.04 1.78948C111.869 1.89459 111.752 2.08473 111.634 2.27492C111.424 1.93461 111.246 1.45667 111.036 1.11636C110.28 -0.297437 109.472 2.19996 109.893 2.88058ZM79.8093 65.3053C79.3316 69.4792 79.2992 73.6131 79.4895 77.727C78.7588 75.5925 77.8378 73.3404 77.8077 71.0082C78.4007 69.1139 79.0787 67.167 79.8093 65.3053ZM77.3123 72.4896C77.6902 75.1946 78.8539 77.6494 79.6247 80.2293C79.9452 83.7926 80.4558 87.4735 81.3593 91.0293C79.3423 87.5737 76.9849 84.3282 75.4458 80.6949C75.8211 77.8772 76.4716 75.1246 77.3123 72.4896ZM75.1606 82.5166C76.1817 85.8822 78.5516 88.7674 80.6987 91.6725C78.5916 89.2128 76.0792 87.2385 75.0781 84.0956C75.0706 83.5125 75.1156 83.0146 75.1606 82.5166ZM75.2185 89.6508C75.0457 88.2294 75.0107 86.8406 74.9756 85.4518C75.7714 87.311 76.9726 88.6848 78.4165 90.2612C79.9455 91.7851 81.2192 93.4666 82.3554 95.1156C82.5005 95.7312 82.7308 96.2942 82.8759 96.9098C83.8244 99.9676 84.9431 102.92 86.3696 105.801C83.259 102.668 79.3502 100.145 77.0379 96.402C76.2221 94.3201 75.5238 92.048 75.2185 89.6508ZM78.5695 99.4524C81.0569 102.147 84.3426 104.232 86.9151 106.874C88.0262 109.244 89.255 111.423 90.5362 113.688L90.5888 113.773C86.0219 109.424 81.52 104.8 78.5695 99.4524ZM97.8389 135.976C97.4786 135.963 97.1708 136.036 96.8105 136.023C92.4214 136.149 88.0848 136.359 83.7157 136.707C78.746 134.37 74.9848 129.994 70.6356 126.568C79.9094 128.832 89.028 132.368 97.8389 135.976ZM43.5101 124.517C51.9855 123.396 60.3133 124.129 68.4335 126.048C73.3983 129.328 77.5273 134.3 82.9951 136.682C78.9338 136.958 74.7874 137.285 70.6935 137.699C63.1439 136.132 56.3249 132.704 49.153 129.847C45.2393 128.268 40.8802 126.729 36.3259 126.016C38.7356 125.351 41.1128 124.823 43.5101 124.517ZM32.2271 127.373C38.1827 127.69 43.6028 129.044 49.601 131.333C56.2874 133.785 62.8762 136.65 69.8553 137.864C68.8794 137.996 67.9885 138.076 67.0126 138.209C66.9275 138.262 66.7899 138.229 66.7899 138.229C53.2897 135.402 39.6341 129.85 25.8187 130.508C27.8606 129.247 30.0075 128.156 32.2271 127.373ZM12.937 141.051C14.3558 139.352 15.9122 137.686 17.5737 136.189C19.608 134.345 21.8851 132.703 24.1822 131.284C38.2328 130.245 51.2277 136.441 64.9557 138.304C59.8534 138.988 54.7187 139.809 49.689 140.8C37.7978 140.387 24.1248 136.139 12.937 141.051ZM2.04255 160.71C4.48209 154.384 7.60979 148.221 11.6559 142.783C23.1114 137.352 35.6308 141.256 48.065 141.215C44.4041 141.949 40.7632 142.905 37.1749 143.946C27.8112 146.674 17.1188 150.105 9.14905 155.85C8.80874 156.061 8.60862 157.83 9.25671 157.547C13.7083 155.62 17.7395 153.012 22.1911 151.085C26.8128 149.053 31.6448 147.362 36.4968 145.893C41.041 144.496 45.7429 143.355 50.4648 142.436C37.4053 148.505 24.576 155.137 11.8518 161.939C8.58872 161.603 5.27309 161.183 2.04255 160.71ZM12.0745 161.918C26.1224 155.357 40.1178 148.71 53.903 141.723C54.3484 141.683 54.8263 141.505 55.2718 141.465C41.3264 146.671 29.9786 157.794 15.5077 162.149C14.4267 162.111 13.2081 162.041 12.0745 161.918ZM16.366 162.206C32.5861 157.829 44.8471 144.378 61.3824 140.512C62.8038 140.339 64.1725 140.081 65.5939 139.908C67.0152 139.736 68.4365 139.563 69.7728 139.443C55.9249 144.235 45.7209 157.591 31.5778 162.095C26.4881 162.418 21.4633 162.466 16.366 162.206ZM60.3946 156.989C58.2927 157.583 56.1907 158.176 53.9512 158.736C47.0948 160.386 40.1458 161.505 33.1893 162.04C49.4219 157.303 60.1713 141.025 77.6201 138.827C77.7052 138.774 77.7903 138.722 77.7903 138.722C81.3536 138.401 84.8844 138.218 88.4152 138.036C77.9005 141.945 70.1661 151.306 60.3946 156.989ZM62.5291 156.259C72.766 150.758 80.3227 140.919 91.8409 137.683C93.1771 137.563 94.4809 137.58 95.8171 137.46C97.291 137.372 98.6798 137.337 100.154 137.249C88.3554 145.36 76.0566 151.899 62.5291 156.259ZM98.0825 27.3364C99.239 37.2007 108.143 45.3355 111.997 54.2387C112.254 55.6074 112.48 57.1138 112.737 58.4826C110.26 53.9009 107.56 49.3392 104.997 44.8101C101.929 39.6529 97.9827 34.2154 97.8348 28.0772C97.8999 27.8019 97.9649 27.5266 98.0825 27.3364ZM97.2018 29.5261C97.4046 33.2796 99.3041 36.9254 101.216 40.2109C104.987 46.6969 108.896 53.2153 112.923 59.5436C113.994 65.4641 115.15 71.3321 116.529 77.18C116.965 79.0267 117.4 80.8734 117.836 82.7201C115.06 76.3242 110.033 70.8493 105.523 65.6421C100.856 60.1796 96.2218 54.5796 92.6933 48.2963C93.4162 41.8552 94.9649 35.6094 97.2018 29.5261ZM107.887 91.9217C100.622 84.5375 94.0631 76.0123 92.5713 65.4149L92.5188 65.3298C92.0056 60.1225 92.0229 54.8225 92.5057 49.7052C95.6663 55.3929 99.848 60.45 104.115 65.4545C109.182 71.3749 113.464 77.5455 118.073 83.8662C120.336 93.0473 122.821 102.208 125.699 111.244C121.127 103.842 113.78 98.0372 107.887 91.9217ZM134.847 105.123C134.693 114.387 133.464 124.196 135.504 133.397C134.959 132.324 134.466 131.335 133.92 130.262C131.205 124.534 129.105 118.661 127.261 112.63C127.136 112.237 127.063 111.93 126.938 111.537C127.458 105.338 129.73 100.644 132.505 95.0512C133.223 93.5497 133.856 92.1009 134.437 90.5669C134.74 95.4339 134.905 100.268 134.847 105.123ZM132.359 70.4581C133.292 76.3461 133.866 82.2215 134.354 88.1496C132.973 92.764 130.503 96.7578 128.539 101.38C127.455 103.812 126.412 106.69 126.345 109.435C123.749 101.047 121.462 92.5868 119.345 84.0213C122.167 75.4607 128.568 67.7457 130.342 59.0099C131.042 62.8085 131.743 66.607 132.359 70.4581ZM129.959 57.2483C128.86 66.507 121.536 74.4397 119.22 83.6284C118.877 82.3122 118.586 81.0811 118.296 79.8499C120.092 72.8633 123.398 67.1779 126.178 60.6416C127.411 57.8815 128.402 54.9187 128.672 51.9308C129.088 53.5549 129.523 55.4016 129.959 57.2483ZM128.019 49.1608C128.017 55.6268 125.274 61.0821 122.297 66.9177C120.423 70.5436 118.366 74.6351 118.163 78.874C115.748 68.4944 113.778 58.0747 112.254 47.6149C113.09 41.9271 115.374 36.8722 117.363 31.5297C118.309 29.0648 119.235 26.3772 119.715 23.7297C122.979 32.0574 125.764 40.5628 128.019 49.1608ZM118.919 21.8705C118.149 27.2831 116.237 31.9901 114.281 37.1951C113.27 39.9352 112.311 42.7604 111.989 45.6631C111.949 45.2177 111.824 44.8248 111.784 44.3794C110.232 33.1139 108.122 21.1353 110.926 9.88211C111.284 8.36818 110.043 6.54901 109.523 8.75109C107.123 19.5188 108.668 30.2013 110.127 40.9363C110.585 44.5321 111.128 48.0754 111.724 51.7038C107.987 42.6104 100.232 35.7643 98.8007 25.835C101.966 18.5906 106.2 11.744 111.489 5.65563C114.027 10.9055 116.584 16.378 118.919 21.8705Z" fill="#A8B626"/>
                    </svg>
                    <svg class="banner-bg-img banner-bg-two" xmlns="http://www.w3.org/2000/svg" width="85" height="82" viewBox="0 0 85 82" fill="none">
                        <path d="M55.03 26.2491C39.9086 14.4172 21.5387 4.61391 2.26021 2.2698C1.84772 1.63466 1.32856 1.03836 0.882156 0.475983L0.809398 0.442065C1.07637 1.00937 1.34334 1.57668 1.50363 2.18282C1.32419 2.18775 1.10591 2.08599 0.926473 2.09092C-0.693381 1.9558 0.131595 3.22607 1.24706 3.3032C1.49925 3.3322 1.82421 3.39511 2.0764 3.42411C10.2414 22.1987 18.5081 40.7551 33.6596 54.9924C47.4478 67.9741 65.1289 77.5449 83.792 81.0193C84.1169 81.0822 84.8347 81.0625 84.786 80.5969C84.316 58.2352 72.3539 39.8162 55.03 26.2491ZM54.9288 27.7962C60.7698 32.5561 66.456 38.2182 71.0464 44.5209C75.6281 53.1224 73.5181 63.9187 77.8864 72.5978C74.592 69.025 71.2976 65.4521 67.8965 61.9181C67.8576 61.8114 67.8188 61.7047 67.6733 61.6369C67.7072 61.5641 67.6683 61.4574 67.5228 61.3896C60.7381 49.7241 60.441 34.9714 51.1108 24.7764C52.3964 25.8185 53.7159 26.7879 54.9288 27.7962ZM37.8649 56.4213C46.5036 59.7397 56.9492 58.232 65.7235 61.2594C66.3882 61.9235 67.019 62.6604 67.6837 63.3246C58.7249 60.1226 48.9095 61.0385 39.8879 58.1615C39.2621 57.604 38.5635 57.0126 37.8649 56.4213ZM50.8198 24.6407C58.7823 34.7296 58.9771 48.3717 65.165 59.2276C60.9148 54.855 56.6308 50.5551 52.3128 46.3279C52.3467 46.2552 52.3079 46.1485 52.1235 45.974C52.0507 45.94 51.978 45.9061 51.9052 45.8722C50.1344 44.161 48.3635 42.4498 46.6654 40.7725C43.3311 34.4353 40.884 27.7147 37.5497 21.3775C35.6568 17.838 33.3761 14.5606 30.3634 12.0933C37.6054 15.5579 44.4405 19.8955 50.8198 24.6407ZM28.1806 11.0758C36.4233 18.2839 38.193 29.1174 43.7545 38.087C43.313 37.704 42.9055 37.2483 42.464 36.8654C42.6434 36.8605 42.7501 36.8216 42.6385 36.681C36.9512 28.3613 34.0993 16.0491 25.6001 9.96144C26.5072 10.2957 27.3075 10.6688 28.1806 11.0758ZM24.727 9.55443C28.5647 13.292 31.2967 17.3112 33.6218 22.2036C35.7575 26.742 37.7866 31.3193 40.8386 35.222C37.3358 31.9063 33.7602 28.5566 30.1506 25.2797C30.1846 25.207 30.1846 25.207 30.073 25.0664C24.581 19.9377 23.3216 11.9993 17.7957 6.94331C20.153 7.77648 22.4764 8.68241 24.727 9.55443ZM17.6163 6.94824C21.9731 11.2821 23.4404 17.6346 27.0214 22.4925C19.7296 15.9048 12.1566 9.54024 4.31225 3.75781C8.85671 4.45913 13.2316 5.52424 17.6163 6.94824ZM3.23071 3.60791C3.4829 3.63691 3.80786 3.69982 4.06006 3.72881C12.8656 11.8193 21.9135 19.5799 30.8208 27.4521C27.6582 26.0664 24.389 24.7196 21.1925 23.4066C18.0687 22.1276 13.8345 20.9509 11.074 18.5126C8.74404 13.4408 6.37524 8.26232 3.23071 3.60791ZM16.8548 30.2416C14.9281 26.7749 13.3213 23.1916 11.6419 19.5745C12.6315 20.3015 13.7956 20.8442 14.9598 21.3869C20.7078 24.0664 26.6691 26.6682 32.6206 28.9111C36.6717 32.571 40.7227 36.2308 44.6331 40.0023C46.2923 41.5729 47.9177 43.2162 49.5769 44.7868C39.0903 40.8726 26.6271 42.1484 18.961 33.7034C18.2138 32.6465 17.5004 31.5168 16.8548 30.2416ZM21.2905 37.4464C28.9165 43.1271 42.4131 42.8645 50.5764 45.8728C55.3019 50.5556 59.9936 55.3112 64.6513 60.1396C55.7604 56.7921 45.5429 58.7605 36.686 55.3403C35.6914 54.4338 34.6968 53.5273 33.7362 52.5481C29.0495 47.9719 24.8863 42.8427 21.2905 37.4464ZM40.5865 58.7528C49.4386 61.9936 59.4334 61.0729 68.3872 64.0954C71.012 66.8247 73.6029 69.6267 76.1938 72.4288C69.1952 71.292 61.9351 71.0962 55.1931 68.839C50.0852 65.9265 45.1808 62.5774 40.5865 58.7528ZM82.6371 79.5066C73.3442 77.2117 64.526 73.8982 56.2506 69.4205C62.7793 71.7554 70.059 72.6689 76.8246 73.1657C78.7847 75.2308 80.6381 77.3348 82.5644 79.4727C82.5983 79.4 82.5983 79.4 82.6371 79.5066ZM82.6656 77.9256C81.5545 76.6991 80.3706 75.4387 79.2595 74.2122C75.0225 66.3914 76.6139 56.3276 73.628 48.2929C79.2961 57.2237 82.9134 67.3241 82.6656 77.9256Z" fill="white"/>
                    </svg>
                    <svg  class="banner-bg-img banner-bg-three" xmlns="http://www.w3.org/2000/svg" width="59" height="69" viewBox="0 0 59 69" fill="none">
                        <path d="M58.2691 9.30778C58.2784 9.20821 58.3872 9.11794 58.3965 9.01837C58.4058 8.9188 58.3156 8.80993 58.2346 8.6015C58.0687 6.07514 57.6944 3.62976 57.1303 1.06622C57.0679 0.658658 56.5077 0.204615 56.0006 0.257701C38.6492 2.15291 21.639 9.00126 9.94536 22.3721C7.91146 24.7935 5.96783 27.3238 4.32289 29.882C4.32289 29.882 4.22332 29.8727 4.21402 29.9722L4.20473 30.0718C-2.53035 40.8925 -5.83904 53.7406 -5.12788 66.5622C-5.6443 66.7149 -6.16073 66.8675 -6.67716 67.0202C-7.40202 67.2538 -6.12894 68.6783 -5.51295 68.535C11.9181 63.6342 30.4801 62.7559 43.9129 49.0453C54.3505 38.3693 59.2205 23.8592 58.2691 9.30778ZM56.0789 1.57067C56.6337 4.23378 56.8898 6.86899 56.9468 9.48562C53.5229 13.8864 49.2613 16.5016 44.2935 19.1512C41.6463 20.6115 39.0084 21.9721 36.632 23.7589C42.8054 16.8027 48.8885 9.7376 54.7725 2.65391C54.7725 2.65391 54.7818 2.55434 54.6822 2.54504C45.5761 12.9436 36.2802 23.2239 26.7944 33.3861C28.6319 29.8416 29.4113 25.7965 30.3805 21.8696C31.7256 16.0695 33.7835 11.2399 36.6658 6.18598C42.9094 3.85631 49.4769 2.36036 56.0789 1.57067ZM29.7076 19.3963C28.2816 24.988 26.9645 30.4894 24.7605 35.8075C22.3098 38.3909 19.859 40.9742 17.3989 43.6572C17.0724 43.928 16.6462 44.1895 16.3196 44.4603C16.2107 44.5506 16.4006 44.6688 16.5002 44.678C15.9465 45.229 15.4925 45.7892 14.9482 46.2405C18.74 35.7476 17.077 23.4397 22.4155 13.5933C26.7049 10.6795 31.2373 8.39088 36.0312 6.52846C32.3298 9.59767 30.8414 14.7818 29.7076 19.3963ZM22.2163 13.5747C17.3505 22.6618 17.8865 33.0566 15.1647 42.846C16.4368 33.5238 15.0485 23.652 19.8492 15.262C20.6019 14.7297 21.4543 14.2066 22.2163 13.5747ZM4.46087 32.707C6.61562 28.9912 9.15933 25.4122 12.173 22.1784C14.2972 19.8658 16.6112 17.6714 19.0965 15.7943C13.3067 25.0964 15.7941 37.1799 13.4148 47.6039C9.62978 51.5692 5.85408 55.4349 2.07837 59.3007C5.72809 51.4058 2.84627 41.3945 4.46087 32.707ZM2.76016 35.8626C1.6182 43.7908 3.43535 52.2965 1.28843 60.2313C-0.481271 61.9743 -2.26028 63.8169 -3.93041 65.5692C-4.177 55.3019 -1.80695 44.9775 2.76016 35.8626ZM40.055 49.4885C27.8968 60.3051 12.8727 62.0159 -2.13818 65.7366C-0.0233037 63.5236 2.08229 61.4102 4.0976 59.1879C10.7143 56.0896 17.9761 55.7632 25.0879 53.8159C31.1761 52.0744 37.6189 49.7633 43.1496 46.4631C42.1512 47.4747 41.1529 48.4863 40.055 49.4885ZM45.9548 43.3103C38.2774 47.0126 30.9797 50.9512 22.5363 53.176C17.9071 54.3507 11.2706 54.4341 6.52975 56.8037C8.76279 54.4009 10.9865 52.0976 13.2196 49.6948C13.3098 49.8037 13.509 49.8222 13.5183 49.7227C13.6365 49.5328 13.655 49.3337 13.6736 49.1346C15.4619 47.1924 17.2409 45.3498 18.9296 43.3984C31.1115 37.7062 46.6296 33.9324 55.5365 23.5153C53.9711 30.6004 50.6227 37.4187 45.9548 43.3103ZM56.0397 21.3527C50.5939 26.9707 44.1206 30.6851 36.8879 33.9268C31.4408 36.3308 25.9314 38.3273 20.8361 41.2663C24.9756 36.7315 29.1151 32.1967 33.155 27.6526C40.2032 22.0837 51.9973 19.4687 56.9507 11.5951C57.0422 14.918 56.7355 18.2037 56.0397 21.3527Z" fill="white"/>
                        </svg>
                </div>
                <div class="container">
                    <div class="banner-content">
                        <div class="section-title">
                            <div class="subtitle">{{ !empty($homepage_header_sub_title) ? $homepage_header_sub_title : __('bestseller') }}</div>
                            <h2>{{ !empty($homepage_header_title) ? $homepage_header_title : 'Home Accessories' }}</h2>
                            <p>{{ !empty($homepage_header_Sub_text) ? $homepage_header_Sub_text : 'There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.' }}</p>
                        </div>
                        <div class="banner-btn-wrp">
                            <a href="{{ route('store.categorie.product', $store->slug) }}" tabindex="0" class="btn btn-white">
                                {{ !empty($homepage_header_Button) ? $homepage_header_Button : __('Shop Now') }}
                                <div class="btn-svg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M11 7.99997C11 8.12784 10.9512 8.25584 10.8535 8.35347L5.85353 13.3535C5.65816 13.5488 5.34178 13.5488 5.14653 13.3535C4.95128 13.1581 4.95116 12.8417 5.14653 12.6465L9.79303 7.99997L5.14653 3.35347C4.95116 3.15809 4.95116 2.84172 5.14653 2.64647C5.34191 2.45122 5.65828 2.45109 5.85353 2.64647L10.8535 7.64647C10.9512 7.74409 11 7.87209 11 7.99997Z" fill="white"/>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach
    
    {{-- Promotion --}}
    @include('storefront.promotion')

    <section class="bestseller-sec pt pb">
        <div class="container">
            @foreach ($getStoreThemeSetting as $storesetting)
                @if ($storesetting['section_name'] == 'Quote' && $storesetting['section_enable'] == 'on')
                    @php
                        foreach ($storesetting['inner-list'] as $value) {
                            $quote = $value['field_default_text'];
                        }
                    @endphp
                    <div class="section-title text-center">
                        <h2>{{ __('Best Seller') }}</h2>
                        <p>{{ $quote }}</p>
                    </div>
                @endif
            @endforeach
            @if (count($topRatedProducts) > 0)
                <div class="bestseller-slider">
                    @foreach ($topRatedProducts as $k => $topRatedProduct)
                        <div class="product-card">
                            <div class="product-card-inner">
                                <div class="product-card-image">
                                    <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product_id]) }}" class="default-img img-wrapper">
                                        @if (!empty($topRatedProduct->product->is_cover))
                                            <img src="{{ $coverImg . $topRatedProduct->product->is_cover }}" alt="product-card-image"
                                                loading="lazy">
                                        @else
                                            <img src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" alt="product-card-image"
                                                loading="lazy">
                                        @endif
                                    </a>
                                    <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product_id]) }}" class="hover-img img-wrapper">
                                        @if (isset($topRatedProduct->product) && isset($topRatedProduct->product->product_img) && !empty($topRatedProduct->product->product_img->product_images))
                                            <img src="{{ $productImg . $topRatedProduct->product->product_img->product_images }}" alt="product-card-image"
                                                loading="lazy">
                                        @elseif (!empty($topRatedProduct->product->is_cover))
                                            <img src="{{ $coverImg . $topRatedProduct->product->is_cover }}" alt="product-card-image"
                                                loading="lazy">
                                        @else
                                            <img src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" alt="product-card-image"
                                                loading="lazy">
                                        @endif
                                    </a>
                                    <div class="pro-btn-wrapper">
                                        <div class="pro-btn">
                                            @if (Auth::guard('customers')->check())
                                                @if (!empty($wishlist) && isset($wishlist[$topRatedProduct->product->id]['product_id']))
                                                    @if ($wishlist[$topRatedProduct->product->id]['product_id'] != $topRatedProduct->product->id)
                                                        <a href="javascript:void(0)" tabindex="0" class="wishlist-btn btn add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}"
                                                            data-id="{{ $topRatedProduct->product->id }}">
                                                            <svg width="28" height="23" viewBox="0 0 28 23" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z"
                                                                    fill="white" stroke="black"></path>
                                                            </svg>
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0)" tabindex="0" class="wishlist-btn btn wishlist-active wishlist_{{ $topRatedProduct->product->id }}"
                                                            disabled>
                                                            <svg width="28" height="23" viewBox="0 0 28 23" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z"
                                                                    fill="white" stroke="black"></path>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                @else
                                                    <a href="javascript:void(0)" tabindex="0" class="wishlist-btn btn add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}"
                                                        data-id="{{ $topRatedProduct->product->id }}">
                                                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z"
                                                                fill="white" stroke="black"></path>
                                                        </svg>
                                                    </a>
                                                @endif
                                            @else
                                                <a href="javascript:void(0)" class="wishlist-btn btn add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}"
                                                    data-id="{{ $topRatedProduct->product->id }}">
                                                    <svg width="28" height="23" viewBox="0 0 28 23" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z"
                                                            fill="white" stroke="black"></path>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <div class="product-content-top text-center">
                                        <div class="product-cart-btn flex align-center justify-center">
                                            @if ($topRatedProduct->product->enable_product_variant == 'on')
                                                <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product->id]) }}" class="compare-btn btn cart-btn">
                                                    {{ __('Add To Cart') }}
                                                </a>
                                            @else
                                                <a data-id="{{ $topRatedProduct->product->id }}" class="compare-btn btn cart-btn add_to_cart">
                                                    {{ __('Add To Cart') }}
                                                </a>
                                            @endif
                                        </div>
                                        <div class="product-rating flex align-center justify-center rating">
                                            @if ($store->enable_rating == 'on')
                                                @php
                                                    $rating = $topRatedProduct->product->product_rating();
                                                @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @php
                                                        $icon = 'fa-star';
                                                        $color = '';
                                                        $newVal1 = $i - 0.5;
                                                        if ($rating >= $newVal1) {
                                                            $color = 'text-warning';
                                                        }
                                                        if ($rating < $i && $rating >= $newVal1) {
                                                            $icon = 'fa-star-half-alt';
                                                        }
                                                    @endphp
                                                    <i class="star fas {{ $icon . ' ' . $color }}"></i>
                                                @endfor
                                            @endif                                                    
                                        </div>
                                        <h3>
                                            <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product->id]) }}">{{ $topRatedProduct->product->name }}</a>
                                        </h3>
                                        <div class="product-subtitle">{{ $topRatedProduct->product->product_category() }}</div>
                                    </div>
                                    <div class="product-content-bottom">
                                        <div class="price">
                                            <ins>
                                                @if ($topRatedProduct->product->enable_product_variant == 'on')
                                                    {{ __('In variant') }}
                                                @else
                                                    {{ \App\Models\Utility::priceFormat($topRatedProduct->product->price) }}
                                                @endif
                                            </ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    @foreach ($getStoreThemeSetting as $storethemesetting)
        @if (isset($storethemesetting['section_name']) &&
            $storethemesetting['section_name'] == 'Home-Categories' &&
            $storethemesetting['section_enable'] == 'on' &&
            !empty($pro_categories))
            @php
                $Titlekey = array_search('Title', array_column($storethemesetting['inner-list'], 'field_name'));
                $Title = $storethemesetting['inner-list'][$Titlekey]['field_default_text'];

                $Description_key = array_search('Description', array_column($storethemesetting['inner-list'], 'field_name'));
                $Description = $storethemesetting['inner-list'][$Description_key]['field_default_text'];
            @endphp
            <section class="category-sec tabs-wrapper pt pb">
                <div class="container">
                    <div class="category-col">
                        <div class="section-title">
                            <h2>{{ !empty($Title) ? $Title : 'Categories' }}</h2>
                            <p>{{ !empty($Description) ? $Description : 'There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.' }}</p>
                        </div>
                        <ul class="category-tab tabs">
                            @foreach ($pro_categories as $key => $pro_categorie)
                                <li class="category-item {{ $key == 0 ? 'active' : '' }}" data-tab="category-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $pro_categorie) !!}">
                                    <h3>{{ $pro_categorie->name }}</h3>
                                    <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}" class="category-btn">{{ __('View More') }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="category-hover-image-col">
                    @foreach ($pro_categories as $key => $pro_categorie)
                        <div class="category-img-wrp {{ $key == 0 ? 'active show' : '' }}" id="category-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $pro_categorie) !!}">
                            <div class="category-img">
                                @if (!empty($pro_categorie->categorie_img) )
                                    <img alt="category-image"
                                        src="{{ $productImg . (!empty($pro_categorie->categorie_img) ? $pro_categorie->categorie_img : 'default.jpg') }}" loading="lazy">
                                @else
                                    <img alt="category-image"
                                        src="{{ asset(Storage::url('uploads/product_image/default.jpg')) }}" loading="lazy">
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    @endforeach

    @if ($products['Start shopping']->count() > 0)
        <section class="product-sec tabs-wrapper pt pb">
            <div class="container">
                <div class="section-title text-center">
                    <h2>{{ __('Our Products') }}</h2>
                    <p>{{ $quote }}</p>
                </div>
                <div class="tab-head-row flex justify-center">
                    <ul class="tabs product-tabs flex no-wrap align-center">
                        @foreach ($categories as $key => $category)
                            <li class="tab-link {{ $key == 0 ? 'active' : '' }}" data-tab="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $category) !!}">
                                <a href="javascript:;" >
                                    {{ __($category) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tabs-container">
                    @foreach ($products as $key => $items)
                        <div id="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $key) !!}" class="tab-content {{ $key == 'Start shopping' ? 'active show' : '' }}">
                            @if ($items->count() > 0)
                                <div class="row">
                                    @foreach ($items as $product)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                            @include('storefront.theme6.common.product_section')
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @foreach ($getStoreThemeSetting as $storethemesetting)
        @if (isset($storethemesetting['section_name']) &&
            $storethemesetting['section_name'] == 'Home-Email-Subscriber' &&
            $storethemesetting['section_enable'] == 'on')
            @php
                $emailsubs_img_key = array_search('Subscriber Background Image', array_column($storethemesetting['inner-list'], 'field_name'));
                $emailsubs_img = $storethemesetting['inner-list'][$emailsubs_img_key]['field_default_text'];

                $SubscriberTitle_key = array_search('Subscriber Title', array_column($storethemesetting['inner-list'], 'field_name'));
                $SubscriberTitle = $storethemesetting['inner-list'][$SubscriberTitle_key]['field_default_text'];

                $SubscriberDescription_key = array_search('Subscriber Description', array_column($storethemesetting['inner-list'], 'field_name'));
                $SubscriberDescription = $storethemesetting['inner-list'][$SubscriberDescription_key]['field_default_text'];

                $SubscribeButton_key = array_search('Subscribe Button Text', array_column($storethemesetting['inner-list'], 'field_name'));
                $SubscribeButton = $storethemesetting['inner-list'][$SubscribeButton_key]['field_default_text'];
            @endphp
            <section class="subscribe-banner-sec" style="background-image: url({{ $imgpath . $emailsubs_img }});">
                <div class="container">
                    <div class="subscribe-banner-content">
                        <div class="section-title">
                            <h2>{{ !empty($SubscriberTitle) ? $SubscriberTitle : __('Always on time') }}</h2>
                            <p>{{ !empty($SubscriberDescription) ? $SubscriberDescription : __('There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.') }}</p>
                        </div>
                        {{ Form::open(['route' => ['subscriptions.store_email', $store->id], 'method' => 'POST', 'class' => 'subscribe-form']) }}
                            <div class="subscribe-form-wrp">
                                {{ Form::email('email', null, ['placeholder' => __('Enter Your Email Address'), 'class' => 'newsletter-input', 'required' => 'required']) }}
                                <button type="submit" class="btn btn-white">
                                    {{ $SubscribeButton }}
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_483_281)">
                                        <path d="M9.1145 18.3457V23.177C9.1145 23.5145 9.33117 23.8134 9.652 23.9197C9.73221 23.9457 9.8145 23.9582 9.89575 23.9582C10.1395 23.9582 10.3749 23.8436 10.5249 23.6395L13.351 19.7936L9.1145 18.3457Z" fill="#A8B626"/>
                                        <path d="M24.6719 0.144884C24.4323 -0.0249077 24.1178 -0.0478244 23.8573 0.088634L0.419838 12.3282C0.142755 12.473 -0.020787 12.7688 0.00212966 13.0803C0.026088 13.3928 0.23338 13.6595 0.528171 13.7605L7.0438 15.9876L20.9198 4.12301L10.1823 17.0595L21.1021 20.7918C21.1834 20.8188 21.2688 20.8334 21.3542 20.8334C21.4959 20.8334 21.6365 20.7949 21.7605 20.7199C21.9584 20.5991 22.0928 20.3959 22.1271 20.1678L24.9917 0.896967C25.0344 0.605301 24.9115 0.315717 24.6719 0.144884Z" fill="#A8B626"/>
                                        </g>
                                    </svg>                                    
                                </button>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    @if($getStoreThemeSetting[4]['section_enable'] == 'on')
        <section class="testimonial-sec pt pb">
            <div class="container">
                <div class="section-title text-center">
                    @foreach ($getStoreThemeSetting as $storethemesetting)
                        @if (isset($storethemesetting['section_name']) && $storethemesetting['section_name'] == 'Home-Testimonial' && $storethemesetting['array_type'] == 'inner-list' && $storethemesetting['section_enable'] == 'on')
                            @php
                                $Heading_key = array_search('Heading', array_column($storethemesetting['inner-list'], 'field_name'));
                                $Heading = $storethemesetting['inner-list'][$Heading_key]['field_default_text'];

                                $HeadingSubText_key = array_search('Heading Sub Text', array_column($storethemesetting['inner-list'], 'field_name'));
                                $HeadingSubText = $storethemesetting['inner-list'][$HeadingSubText_key]['field_default_text'];
                            @endphp
                            <h2>{{ !empty($Heading) ? $Heading : __('Testimonials') }}</h2>
                            <p>{{ !empty($HeadingSubText) ? $HeadingSubText : __('Discover the teas our customers can not stop talking about! These handpicked favorites deliver exceptional flavor.') }}</p>
                        @endif
                    @endforeach
                </div>
                <div class="testimonial-slider">
                    @foreach ($testimonials as $key => $testimonial)
                        <div class="testimonial-card">
                            <div class="testimonial-card-inner">
                                <div class="testimonial-content-top flex align-center">
                                    <div class="testimonial-img">
                                        <img src="{{ $testimonialImg . (!empty($testimonial->image) ? $testimonial->image : 'avatar.png') }}" alt="testimonial-card-image" loading="lazy">
                                    </div>
                                    <div class="testimonial-img-content">
                                        <h3>{{ $testimonial->title ?? '' }}</h3>
                                        <span>{{ $testimonial->sub_title ?? '' }}</span>
                                        <div class="testimonial-rating product-rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @php
                                                    $icon = 'fa-star';
                                                    $color = '';
                                                    $newVal1 = $i - 0.5;
                                                    if ($testimonial->ratting >= $newVal1) {
                                                        $color = 'text-warning';
                                                    }
                                                    if ($testimonial->ratting < $i && $testimonial->ratting >= $newVal1) {
                                                        $icon = 'fa-star-half-alt';
                                                    }
                                                @endphp
                                                <i class="star fas {{ $icon . ' ' . $color }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial-content-bottom text-center">
                                    <p>{{ $testimonial->description ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
   
    {{-- Logo slider --}}
    @include('storefront.logo_slider')

</main>
@endsection

