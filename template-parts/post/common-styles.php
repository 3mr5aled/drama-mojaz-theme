<style>
    .arabic-content {
        font-size: 1.15rem;
        line-height: 2;
        color: #333;
        text-align: justify;
    }
    .arabic-content p { 
        margin-bottom: 2rem; 
    }
    .arabic-content h2, .arabic-content h3 { 
        font-family: 'Noto Kufi Arabic', sans-serif; 
        margin-top: 3.5rem; 
        margin-bottom: 1.5rem; 
        color: #111; 
        font-weight: 800;
        line-height: 1.4;
    }
    .arabic-content h2 { 
        font-size: 2rem; 
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .arabic-content h2::before {
        content: '';
        display: inline-block;
        width: 12px;
        height: 32px;
        background: #E31B23;
        border-radius: 4px;
    }
    .arabic-content h3 { 
        font-size: 1.6rem; 
        border-right: 4px solid #E31B23;
        padding-right: 1.25rem;
    }
    .arabic-content ul, .arabic-content ol { 
        margin: 2rem 0; 
        padding-right: 1.5rem;
        list-style: none;
    }
    .arabic-content li { 
        margin-bottom: 1rem; 
        position: relative;
        padding-right: 1.5rem;
    }
    .arabic-content ul li::before {
        content: '\f2ee';
        font-family: 'remixicon';
        position: absolute;
        right: 0;
        color: #E31B23;
        font-size: 1rem;
    }
    .arabic-content blockquote { 
        border: none;
        padding: 3rem 2.5rem; 
        background: #f9fafb; 
        border-radius: 2rem; 
        margin: 3.5rem 0; 
        position: relative;
        font-size: 1.5rem;
        font-weight: 700;
        color: #111;
        line-height: 1.7;
    }
    .arabic-content blockquote::before {
        content: "\ea09";
        font-family: 'remixicon';
        position: absolute;
        top: 1rem;
        right: 2rem;
        font-size: 3rem;
        color: #E31B23;
        opacity: 0.1;
    }
    .arabic-content img { 
        border-radius: 2rem; 
        box-shadow: 0 20px 50px rgba(0,0,0,0.1); 
        margin: 3.5rem auto; 
    }
    .arabic-content a {
        color: #E31B23;
        text-decoration: none;
        border-bottom: 2px solid rgba(227, 27, 35, 0.2);
        transition: all 0.3s;
        font-weight: 700;
    }
    .arabic-content a:hover {
        background: rgba(227, 27, 35, 0.05);
        border-bottom-color: #E31B23;
    }

    /* Audio Player Custom Styles */
    .audio-reading-player {
        direction: ltr;
        user-select: none;
    }
    .audio-reading-player #audioProgressFill {
        transition: none;
    }
    .audio-reading-player #audioProgressHandle {
        transition: none;
    }
    @media (max-width: 640px) {
        .audio-reading-player {
            padding-left: 1rem;
            padding-right: 1rem;
            gap: 0.75rem;
        }
    }
</style>
