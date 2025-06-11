@php
    $logo = \App\Models\Utility::get_file('uploads/logo/');
@endphp

<div class="quick-access-section mb-4">
    <h2 class="mb-3">{{ __('Acesso rápido') }}</h2>
    <div class="quick-access-buttons">
        <div class="btn-group dashboard-btn-wrp">
            <a href="{{ route('store.grid') }}" class="btn btn-primary">
                {{ __('Visitar minha loja') }}
            </a>

            <a href="{{ route('store-theme.index') }}" class="btn btn-light-primary">
                {{ __('Loja de temas') }}
            </a>

            <a href="{{ route('store-resource.index') }}" class="btn btn-light-primary">
                {{ __('Loja de serviços') }}
            </a>

            <a href="#" id="socialShareButton" data-bs-placement="top" data-bs-toggle="tooltip" title="{{ __('Share Link') }}"
                class="socialShareButton btn btn-primary share-btn d-flex align-items-center justify-content-center">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_2_144)">
                        <path d="M12.6289 2.60012C12.6289 3.58736 11.8286 4.38769 10.8414 4.38769C9.85415 4.38769 9.05392 3.58736 9.05392 2.60012C9.05392 1.61298 9.85415 0.812653 10.8414 0.812653C11.8286 0.812653 12.6289 1.61298 12.6289 2.60012Z" fill="white"/>
                        <path d="M10.8416 4.80003C9.62825 4.80003 8.64162 3.81329 8.64162 2.59996C8.64162 1.38673 9.62825 0.399994 10.8416 0.399994C12.0549 0.399994 13.0415 1.38673 13.0415 2.59996C13.0415 3.81329 12.0549 4.80003 10.8416 4.80003ZM10.8416 1.22499C10.0832 1.22499 9.46662 1.84213 9.46662 2.59996C9.46662 3.35789 10.0832 3.97503 10.8416 3.97503C11.6 3.97503 12.2165 3.35789 12.2165 2.59996C12.2165 1.84213 11.6 1.22499 10.8416 1.22499Z" fill="white"/>
                        <path d="M12.6289 11.4C12.6289 12.3872 11.8286 13.1875 10.8414 13.1875C9.85415 13.1875 9.05392 12.3872 9.05392 11.4C9.05392 10.4128 9.85415 9.61246 10.8414 9.61246C11.8286 9.61246 12.6289 10.4128 12.6289 11.4Z" fill="white"/>
                        <path d="M10.8416 13.5998C9.62825 13.5998 8.64162 12.6131 8.64162 11.3998C8.64162 10.1865 9.62825 9.19977 10.8416 9.19977C12.0549 9.19977 13.0415 10.1865 13.0415 11.3998C13.0415 12.6131 12.0549 13.5998 10.8416 13.5998ZM10.8416 10.0248C10.0832 10.0248 9.46662 10.6419 9.46662 11.3998C9.46662 12.1577 10.0832 12.7748 10.8416 12.7748C11.6 12.7748 12.2165 12.1577 12.2165 11.3998C12.2165 10.6419 11.6 10.0248 10.8416 10.0248Z" fill="white"/>
                        <path d="M4.92893 7.00081C4.92893 7.98806 4.12861 8.78828 3.14137 8.78828C2.15423 8.78828 1.3539 7.98806 1.3539 7.00081C1.3539 6.01357 2.15423 5.21335 3.14137 5.21335C4.12861 5.21335 4.92893 6.01357 4.92893 7.00081Z" fill="white"/>
                        <path d="M3.14132 9.20074C1.92809 9.20074 0.941352 8.21411 0.941352 7.00078C0.941352 5.78745 1.92809 4.80081 3.14132 4.80081C4.35465 4.80081 5.34139 5.78745 5.34139 7.00078C5.34139 8.21411 4.35465 9.20074 3.14132 9.20074ZM3.14132 5.62581C2.38289 5.62581 1.76635 6.24285 1.76635 7.00078C1.76635 7.75871 2.38289 8.37574 3.14132 8.37574C3.89985 8.37574 4.51639 7.75871 4.51639 7.00078C4.51639 6.24285 3.89985 5.62581 3.14132 5.62581Z" fill="white"/>
                        <path d="M4.43993 6.73615C4.24849 6.73615 4.06258 6.63655 3.96137 6.4584C3.81121 6.19495 3.90366 5.85888 4.16712 5.70812L9.27049 2.79867C9.53395 2.64741 9.87001 2.73986 10.0208 3.00432C10.1709 3.26777 10.0785 3.60383 9.81502 3.75459L4.71154 6.66404C4.62574 6.71299 4.53228 6.73615 4.43993 6.73615Z" fill="white"/>
                        <path d="M9.54316 11.2741C9.45071 11.2741 9.35726 11.2509 9.27145 11.202L4.16797 8.29251C3.90452 8.14235 3.81217 7.80629 3.96233 7.54223C4.11188 7.27828 4.44845 7.18532 4.7125 7.33659L9.81598 10.246C10.0794 10.3962 10.1718 10.7323 10.0216 10.9963C9.91991 11.1745 9.734 11.2741 9.54316 11.2741Z" fill="white"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_2_144">
                            <rect width="13.2" height="13.2" fill="white" transform="translate(0.4 0.399994)"/>
                        </clipPath>
                    </defs>
                </svg>
            </a>
        </div>

        <div id="sharingButtonsContainer" class="sharingButtonsContainer" style="display: none;">
            <div class="Demo1 d-flex align-items-center justify-content-center hidden"></div>
        </div>
    </div>
</div>

<style>
.quick-access-section {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.quick-access-buttons {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.quick-access-buttons .btn {
    padding: 10px 20px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-light-primary {
    background: rgba(var(--primary-rgb), 0.1);
    color: var(--primary);
    border: 1px solid transparent;
}

.btn-light-primary:hover {
    background: var(--primary);
    color: #fff;
}

.share-btn {
    width: 40px;
    height: 40px;
    padding: 0;
    border-radius: 50%;
}

.share-btn svg {
    width: 20px;
    height: 20px;
}
</style> 