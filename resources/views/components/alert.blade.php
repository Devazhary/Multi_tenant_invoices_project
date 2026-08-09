@php
    $types = [
        'success' => [
            'title' => 'تمت العملية بنجاح',
            'color' => 'green',
            'icon' => '<svg fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>',
            'glow' => 'rgba(34, 197, 94, 0.25)'
        ],
        'error' => [
            'title' => 'حدث خطأ',
            'color' => 'red',
            'icon' => '<svg fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>',
            'glow' => 'rgba(239, 68, 68, 0.25)'
        ],
        'warning' => [
            'title' => 'تنبيه',
            'color' => 'yellow',
            'icon' => '<svg fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>',
            'glow' => 'rgba(234, 179, 8, 0.25)'
        ],
        'info' => [
            'title' => 'معلومة',
            'color' => 'blue',
            'icon' => '<svg fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>',
            'glow' => 'rgba(59, 130, 246, 0.25)'
        ],
    ];

    $hasFlash = false;
    foreach($types as $type => $data) {
        if(session()->has($type)) {
            $hasFlash = true;
            break;
        }
    }
@endphp

@if($hasFlash)
<style>
    .flash-container {
        position: fixed;
        right: 1.5rem;
        top: 2rem;
        z-index: 99999;
        width: calc(100% - 3rem);
        max-width: 26rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        pointer-events: none;
    }

    .flash-message {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        overflow: hidden;
        border-radius: 1.25rem;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        padding: 1.25rem;
        pointer-events: auto;
        
        /* Initial state for transition */
        opacity: 0;
        transform: translateX(120%) scale(0.9);
        /* A bouncy transition for premium feel */
        transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.4s ease, box-shadow 0.3s ease;
        box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0,0,0,0.02);
    }
    
    .flash-message.show {
        opacity: 1;
        transform: translateX(0) scale(1);
    }
    
    .flash-message.hide {
        opacity: 0;
        transform: translateX(120%) scale(0.9);
    }

    .dark .flash-message {
        background: rgba(17, 24, 39, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255,255,255,0.02);
    }

    .flash-icon {
        display: flex;
        height: 3.25rem;
        width: 3.25rem;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 1rem;
        padding: 0.75rem;
        box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.5);
    }
    
    .dark .flash-icon {
        box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.1);
    }

    .flash-icon.green { background: linear-gradient(135deg, #4ade80, #16a34a); color: white; }
    .flash-icon.red { background: linear-gradient(135deg, #f87171, #dc2626); color: white; }
    .flash-icon.yellow { background: linear-gradient(135deg, #facc15, #ca8a04); color: white; }
    .flash-icon.blue { background: linear-gradient(135deg, #60a5fa, #2563eb); color: white; }

    .flash-content { flex: 1; padding-top: 0.125rem; }
    .flash-title {
        font-weight: 800;
        color: #111827;
        margin: 0;
        font-size: 1.05rem;
        letter-spacing: -0.01em;
    }
    .dark .flash-title { color: #f9fafb; }
    
    .flash-desc {
        margin-top: 0.35rem;
        font-size: 0.875rem;
        color: #4b5563;
        margin-bottom: 0;
        line-height: 1.5;
        font-weight: 500;
    }
    .dark .flash-desc { color: #d1d5db; }
    
    .flash-close {
        font-size: 1.25rem;
        color: #9ca3af;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 0.25rem;
        line-height: 1;
        border-radius: 0.5rem;
        transition: all 0.2s;
        margin-top: -0.25rem;
        margin-left: -0.25rem;
    }
    .flash-close:hover { 
        color: #111827; 
        background-color: rgba(0,0,0,0.05);
        transform: rotate(90deg);
    }
    .dark .flash-close:hover { 
        color: #ffffff; 
        background-color: rgba(255,255,255,0.1);
    }
    
    .flash-progress-wrapper {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .dark .flash-progress-wrapper {
        background: rgba(255,255,255,0.05);
    }

    .flash-progress {
        height: 100%;
        width: 100%;
        transform-origin: right;
    }
    
    .flash-progress.green { background: linear-gradient(90deg, #4ade80, #16a34a); box-shadow: 0 0 10px #4ade80; }
    .flash-progress.red { background: linear-gradient(90deg, #f87171, #dc2626); box-shadow: 0 0 10px #f87171; }
    .flash-progress.yellow { background: linear-gradient(90deg, #facc15, #ca8a04); box-shadow: 0 0 10px #facc15; }
    .flash-progress.blue { background: linear-gradient(90deg, #60a5fa, #2563eb); box-shadow: 0 0 10px #60a5fa; }
</style>

<div id="flash-messages" class="flash-container" dir="rtl">
    @foreach ($types as $type => $data)
        @if (session()->has($type))
            <div class="flash-message" 
                 data-duration="2500" 
                 style="box-shadow: 0 15px 35px -5px {{ $data['glow'] }}, 0 0 0 1px rgba(0,0,0,0.02);"
                 onmouseenter="this.style.boxShadow='0 20px 40px -5px {{ $data['glow'] }}, 0 0 0 1px rgba(0,0,0,0.04)'"
                 onmouseleave="this.style.boxShadow='0 15px 35px -5px {{ $data['glow'] }}, 0 0 0 1px rgba(0,0,0,0.02)'">
                
                {{-- Icon --}}
                <div class="flash-icon {{ $data['color'] }}">
                    {!! $data['icon'] !!}
                </div>

                {{-- Message --}}
                <div class="flash-content">
                    <h3 class="flash-title">
                        {{ $data['title'] }}
                    </h3>
                    <p class="flash-desc">
                        {{ session($type) }}
                    </p>
                </div>

                {{-- Close --}}
                <button type="button" class="flash-close" onclick="closeFlashMessage(this)">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 1.25rem; height: 1.25rem;"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>

                {{-- Progress --}}
                <div class="flash-progress-wrapper">
                    <div class="flash-progress {{ $data['color'] }}"></div>
                </div>
            </div>
        @endif
    @endforeach
</div>

<script>
    function closeFlashMessage(button) {
        const message = button.closest('.flash-message');
        if(message && !message.classList.contains('hide')) {
            message.classList.remove('show');
            message.classList.add('hide');
            setTimeout(() => message.remove(), 600); // Wait for transition
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const messages = document.querySelectorAll('.flash-message');
        
        messages.forEach((message, index) => {
            const duration = Number(message.dataset.duration) || 2500;
            const progress = message.querySelector('.flash-progress');
            
            let isHovered = false;
            let elapsed = 0;
            let lastTime = Date.now();
            let animationFrameId;

            // Simple show class triggers the CSS transition (no keyframes)
            setTimeout(() => {
                message.classList.add('show');
                lastTime = Date.now();
                animationFrameId = requestAnimationFrame(tick);
            }, 100 + (index * 150));

            // Pause on hover
            message.addEventListener('mouseenter', () => { isHovered = true; lastTime = Date.now(); });
            message.addEventListener('mouseleave', () => { isHovered = false; lastTime = Date.now(); });

            const tick = () => {
                if (message.classList.contains('hide')) return;

                const now = Date.now();
                if (!isHovered) {
                    elapsed += (now - lastTime);
                }
                lastTime = now;

                if(progress) {
                    const remainingPercent = Math.max(0, 1 - (elapsed / duration));
                    progress.style.transform = `scaleX(${remainingPercent})`;
                }

                if (elapsed < duration) {
                    animationFrameId = requestAnimationFrame(tick);
                } else {
                    closeFlashMessage(message.querySelector('.flash-close') || message);
                }
            };
        });
    });
</script>
@endif