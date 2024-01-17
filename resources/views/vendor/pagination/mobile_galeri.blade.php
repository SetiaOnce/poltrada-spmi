@if ($paginator->hasPages())

<nav aria-label="Page navigation example">
     <ul class="pagination justify-content-center pagination-one direction-rtl">
          @if ($paginator->onFirstPage())
               <li  class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <a class="page-link" href="#Galeri" aria-label="Previous">
                         <svg width="16" height="16" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path>
                         </svg>
                    </a>
               </li>
          @else
               <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                         <svg width="16" height="16" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path>
                         </svg>
                    </a>
               </li>
          @endif

          @foreach ($elements as $element)
               {{-- "Three Dots" Separator --}}
               @if (is_string($element))
               <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
               @endif

               {{-- Array Of Links --}}
               @if (is_array($element))
               @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                          <li class="page-item active" aria-current="page"><a class="page-link"href="{{ $url }}#Galeri">{{ $page }}</a></li>
                         <!-- <li class="page-item active" aria-current="page"><a class="page-link" href="{{ $url }}#Galeri">{{ $page }}</a></li> -->
                    @else
                         <li><a class="page-link"href="{{ $url }}#Galeri">{{ $page }}</a></li>
                         <!-- <li><a class="page-link" href="{{ $url }}#Galeri">{{ $page }}</a></li> -->
                    @endif
               @endforeach
               @endif
          @endforeach
          
          @if ($paginator->hasMorePages())
          <!-- <li class="page-item">
               <a class="page-link" href="#" aria-label="Next">
                    <svg width="16" height="16" viewBox="0 0 16 16" class="bi bi-chevron-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                         <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"></path>
                    </svg>
               </a>
          </li> -->
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}#Galeri" rel="next" aria-label="@lang('pagination.next')">
                         <svg width="16" height="16" viewBox="0 0 16 16" class="bi bi-chevron-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                         <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"></path>
                    </svg>
                    </a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <a class="page-link" href="#Galeri" aria-label="Next">
                         <svg width="16" height="16" viewBox="0 0 16 16" class="bi bi-chevron-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"></path>
                         </svg>
                    </a>
                </li>
            @endif
          
     </ul>
</nav>


@endif
