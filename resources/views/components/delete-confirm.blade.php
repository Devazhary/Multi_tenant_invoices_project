@props(['action', 'title' => 'تأكيد الحذف', 'message' => 'هل أنت متأكد من عملية الحذف؟ لا يمكن التراجع عن هذا الإجراء.'])

@php
    $modalId = 'deleteModal_' . md5($action . Str::random(10));
@endphp

<!-- Trigger Element -->
<span data-toggle="modal" data-target="#{{ $modalId }}" style="cursor: pointer; display: inline-block;">
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        <button type="button" class="btn btn-sm btn-danger"><i class="las la-trash"></i> حذف</button>
    @endif
</span>

<!-- Premium Delete Confirmation Modal -->
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
            <div class="modal-body p-5 text-center">
                <!-- Close Button -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; left: 1.5rem; top: 1.5rem; outline: none;">
                    <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                </button>

                <!-- Animated Icon -->
                <div class="mb-4 mt-2 d-flex justify-content-center">
                    <div style="width: 80px; height: 80px; background-color: rgba(239, 68, 68, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 4px solid rgba(239, 68, 68, 0.2);">
                        <svg class="text-danger" style="width: 40px; height: 40px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                </div>

                <!-- Title & Message -->
                <h4 class="mb-3" style="font-weight: 800; color: #111827;">{{ $title }}</h4>
                <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">{{ $message }}</p>
                
                <!-- Action Buttons -->
                <div class="d-flex justify-content-center mt-5" style="gap: 1rem;">
                    <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius: 0.75rem; padding: 0.6rem 1.5rem; font-weight: 600; width: 45%;">
                        تراجع
                    </button>
                    
                    <form action="{{ $action }}" method="POST" class="m-0" style="width: 45%;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" style="border-radius: 0.75rem; padding: 0.6rem 1.5rem; font-weight: 600; background: linear-gradient(135deg, #f87171, #dc2626); border: none; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);">
                            تأكيد الحذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
