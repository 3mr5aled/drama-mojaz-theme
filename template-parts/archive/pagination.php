<!-- Enhanced Pagination -->
<div class="mt-20">
    <?php
    echo paginate_links(array(
        'prev_text' => '<i class="ri-arrow-right-s-line"></i><span>السابق</span>',
        'next_text' => '<span>التالي</span><i class="ri-arrow-left-s-line"></i>',
        'type'      => 'list',
        'class'     => 'premium-pagination'
    ));
    ?>
    <style>
        .premium-pagination ul { display: flex; justify-content: center; align-items: center; gap: 0.75rem; list-style: none; }
        .premium-pagination li a, .premium-pagination li span { 
            display: flex; align-items: center; justify-content: center;
            min-width: 44px; height: 44px; padding: 0 1rem; border-radius: 1rem;
            background: white; border: 1px solid #f9fafb;
            font-family: 'Noto Kufi Arabic', sans-serif;
            font-weight: 800; font-size: 0.8125rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            color: #111;
        }
        .premium-pagination li span.current { 
            background: #E31B23; color: white; border-color: #E31B23;
            box-shadow: 0 10px 15px -3px rgba(227, 27, 35, 0.2);
        }
        .premium-pagination li a:hover { 
            background: #111; color: white; transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .premium-pagination li:first-child a, .premium-pagination li:last-child a {
            gap: 0.5rem; width: auto; font-size: 0.75rem;
        }
    </style>
</div>
