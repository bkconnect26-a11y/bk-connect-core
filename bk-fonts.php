<?php
/**
 * Module: BK Connect Fonts & Global Motion Engine
 * Description: Enqueues Fraunces & Poppins typography, Scholaro Design Tokens, Ultra-Slim Floating Header, Complete Mobile Responsiveness Suite, and Full Motion Engine
 */

if (!defined('ABSPATH')) exit;

if (!function_exists('bk_enqueue_scholaro_fonts')) {
function bk_enqueue_scholaro_fonts() {
    wp_enqueue_style(
        'bk-fonts',
        'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..700;1,9..144,400..700&family=Poppins:wght@300;400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500;600&display=swap',
        array(),
        null
    );

    $custom_css = "
        /* ===================================================================== */
        /* GLOBAL RESET & SMOOTH SCROLL                                          */
        /* ===================================================================== */
        html {
            scroll-behavior: smooth !important;
            overflow-x: clip !important;
        }
        body {
            font-family: 'Poppins', sans-serif !important;
            background-color: #FAF8F5 !important;
            color: #111827;
            overflow-x: clip !important;
        }
        h1, h2, h3, .font-display, .font-serif {
            font-family: 'Fraunces', Georgia, serif !important;
        }
        .elementor-heading-title {
            letter-spacing: -0.02em;
        }

        /* ===================================================================== */
        /* FIXED TOP HEADER & RAZOR-SLIM COMPACT TOPNAV                          */
        /* ===================================================================== */
        :root {
            --ppb-navbar-height: 52px;
        }
        @media (min-width: 1025px) {
            :root {
                --ppb-navbar-height: 68px;
            }
        }
        #masthead,
        .elementor-hf-header {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            z-index: 999999 !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #0D3B22 !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
            box-shadow: 0 4px 18px -2px rgba(0, 0, 0, 0.22) !important;
        }

        /* Body top offset handled cleanly by #bk-navbar-spacer in theme header.php */
        body.admin-bar #masthead,
        body.admin-bar .elementor-hf-header {
            top: 32px !important;
        }
        @media screen and (max-width: 782px) {
            body.admin-bar #masthead,
            body.admin-bar .elementor-hf-header {
                top: 46px !important;
            }
        }

        /* 1. Ultra-Slim Top Notification Strip (Exact 20px height) */
        #masthead .elementor-element-sec_top_strip,
        .elementor-element-sec_top_strip {
            padding: 0 14px !important;
            padding-left: clamp(12px, 3.5vw, 18px) !important;
            padding-right: clamp(12px, 3.5vw, 18px) !important;
            min-height: 20px !important;
            height: 20px !important;
            max-height: 20px !important;
            margin: 0 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
            background: #061d11 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-sizing: border-box !important;
        }
        #masthead .elementor-element-sec_top_strip .elementor-container,
        #masthead .elementor-element-sec_top_strip .elementor-column,
        #masthead .elementor-element-sec_top_strip .elementor-widget-wrap,
        #masthead .elementor-element-sec_top_strip .elementor-widget {
            padding: 0 !important;
            margin: 0 !important;
            min-height: unset !important;
            height: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
        }
        .elementor-element-sec_top_strip .elementor-widget-html,
        .elementor-element-sec_top_strip .elementor-widget-html > div {
            padding: 0 !important;
            margin: 0 !important;
            line-height: 1.15 !important;
            display: flex !important;
            align-items: center !important;
        }

        /* 2. Elegant Balanced Main Topnav (Exact 48px height -> Total header 68px) */
        #masthead .elementor-element-sec_main_navbar,
        .elementor-element-sec_main_navbar {
            padding: 0 14px !important;
            padding-left: clamp(12px, 3.5vw, 20px) !important;
            padding-right: clamp(12px, 3.5vw, 20px) !important;
            background: rgba(13, 59, 34, 0.98) !important;
            backdrop-filter: blur(14px) !important;
            -webkit-backdrop-filter: blur(14px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 4px 18px -2px rgba(0, 0, 0, 0.18) !important;
            transition: all 0.2s ease !important;
            min-height: 48px !important;
            height: 48px !important;
            position: relative !important;
            box-sizing: border-box !important;
            display: flex !important;
            align-items: center !important;
        }
        #masthead .elementor-element-sec_main_navbar .elementor-container {
            padding: 0 !important;
            margin: 0 !important;
            min-height: unset !important;
            height: auto !important;
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            justify-content: space-between !important;
            align-items: center !important;
            width: 100% !important;
            max-width: 100% !important;
        }
        #masthead .elementor-element-sec_main_navbar .elementor-column {
            padding: 0 !important;
            margin: 0 !important;
            min-height: unset !important;
            height: auto !important;
        }
        #masthead .elementor-element-sec_main_navbar .elementor-column > .elementor-widget-wrap {
            padding: 0 !important;
            margin: 0 !important;
            min-height: unset !important;
            height: auto !important;
            display: flex !important;
            align-items: center !important;
        }
        #masthead .elementor-element-sec_main_navbar .elementor-widget {
            margin: 0 !important;
            padding: 0 !important;
        }

        .elementor-element-col_brand {
            width: auto !important;
            max-width: calc(100% - 50px) !important;
            flex: 0 1 auto !important;
            margin-right: auto !important;
            margin-left: 0 !important;
        }
        .elementor-element-col_brand a {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            text-decoration: none !important;
        }
        .elementor-element-col_brand img {
            height: 28px !important;
            width: auto !important;
            flex-shrink: 0 !important;
        }
        .elementor-element-col_brand strong {
            font-size: 14px !important;
            line-height: 1.15 !important;
            letter-spacing: -0.2px !important;
        }
        .elementor-element-col_brand span {
            font-size: 8px !important;
            line-height: 1 !important;
        }

        .elementor-element-col_menu {
            width: auto !important;
            flex: 0 0 auto !important;
            display: flex !important;
            justify-content: flex-end !important;
            align-items: center !important;
            margin-left: auto !important;
            margin-right: 0 !important;
            position: relative !important;
        }
        .elementor-element-col_menu .elementor-widget-wrap {
            justify-content: flex-end !important;
            align-items: center !important;
            width: auto !important;
        }
        .elementor-element-w_nav_menu {
            width: auto !important;
            margin-left: auto !important;
        }

        /* When scrolled down, collapse top strip so only main topnav stays */
        #masthead.bk-scrolled .elementor-element-sec_top_strip {
            max-height: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            opacity: 0 !important;
            overflow: hidden !important;
            border: none !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        #masthead .elementor-element-sec_top_strip {
            max-height: 24px;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        #masthead.bk-scrolled .elementor-element-sec_main_navbar {
            background: rgba(13, 59, 34, 0.98) !important;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.32), 0 1px 0 rgba(255, 255, 255, 0.08) !important;
        }

        /* ===================================================================== */
        /* DESKTOP NAVIGATION MENU (min-width: 1025px)                           */
        /* ===================================================================== */
        /* Hide all mobile canvas elements by default so desktop never shows duplicate navbar */
        .bk-canvas-topbar,
        .bk-canvas-close-btn,
        .bk-canvas-bottom-card {
            display: none;
            visibility: hidden;
            height: 0;
            width: 0;
            overflow: hidden;
            padding: 0;
            margin: 0;
            border: none;
        }

        @media (min-width: 1025px) {
            .bk-canvas-topbar,
            .bk-canvas-close-btn,
            .bk-canvas-bottom-card {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                pointer-events: none !important;
                height: 0 !important;
                width: 0 !important;
                overflow: hidden !important;
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
            }

            nav.hfe-nav-menu__layout-horizontal {
                position: static !important;
                visibility: visible !important;
                opacity: 1 !important;
                pointer-events: auto !important;
                transform: none !important;
                background: transparent !important;
                background-color: transparent !important;
                width: auto !important;
                height: auto !important;
                max-width: none !important;
                max-height: none !important;
                display: flex !important;
                align-items: center !important;
                box-shadow: none !important;
                overflow: visible !important;
            }

            .hfe-nav-menu {
                display: flex !important;
                align-items: center !important;
                justify-content: flex-end !important;
                flex-wrap: nowrap !important;
                gap: 2px !important;
                list-style: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .hfe-nav-menu > li {
                margin: 0 !important;
                padding: 0 !important;
                list-style: none !important;
                display: inline-flex !important;
                align-items: center !important;
            }

            /* Container for dropdown items */
            .hfe-nav-menu > li > .hfe-has-submenu-container {
                display: inline-flex !important;
                align-items: center !important;
                margin: 0 !important;
                padding: 0 !important;
                background: transparent !important;
                border: none !important;
                outline: none !important;
                width: auto !important;
                height: auto !important;
            }

            /* Consistent Typography for ALL Top-Level Navbar Links */
            .hfe-nav-menu > li > a.hfe-menu-item,
            .hfe-nav-menu > li > a,
            .hfe-nav-menu > li > .hfe-has-submenu-container > a.hfe-menu-item,
            .hfe-nav-menu > li > .hfe-has-submenu-container > a {
                color: rgba(255, 255, 255, 0.9) !important;
                font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
                font-size: 13px !important;
                font-weight: 600 !important;
                letter-spacing: -0.01em !important;
                padding: 6px 11px !important;
                border-radius: 10px !important;
                transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
                text-decoration: none !important;
                white-space: nowrap !important;
                display: inline-flex !important;
                align-items: center !important;
                line-height: 1.2 !important;
                background: transparent !important;
                border: none !important;
                cursor: pointer !important;
            }

            /* Chevron / Sub-arrow for Dropdown Menus */
            .hfe-nav-menu > li .sub-arrow {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                margin-left: 5px !important;
                margin-right: 0 !important;
                font-size: 10px !important;
                line-height: 1 !important;
                color: rgba(255, 255, 255, 0.75) !important;
                transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), color 0.2s ease !important;
                pointer-events: none !important;
            }
            .hfe-nav-menu > li .sub-arrow i,
            .hfe-nav-menu > li .sub-arrow svg {
                font-size: 10px !important;
                color: inherit !important;
                fill: currentColor !important;
                line-height: 1 !important;
                display: block !important;
            }

            /* Hover State for ALL Top-Level Links */
            .hfe-nav-menu > li:hover > a,
            .hfe-nav-menu > li:hover > .hfe-has-submenu-container > a,
            .hfe-nav-menu > li > a:hover,
            .hfe-nav-menu > li > .hfe-has-submenu-container > a:hover,
            .hfe-nav-menu > li > .hfe-has-submenu-container:hover > a {
                color: #F5B82E !important;
                background: rgba(255, 255, 255, 0.08) !important;
                transform: translateY(-1px);
            }
            .hfe-nav-menu > li:hover .sub-arrow,
            .hfe-nav-menu > li:hover .sub-arrow i,
            .hfe-nav-menu > li > .hfe-has-submenu-container:hover .sub-arrow,
            .hfe-nav-menu > li > .hfe-has-submenu-container:hover .sub-arrow i {
                color: #F5B82E !important;
                fill: #F5B82E !important;
                transform: rotate(180deg) !important;
            }

            /* ACTIVE STATE (MENYALA) FOR CURRENT PAGE OR CURRENT ANCESTOR */
            .hfe-nav-menu > li.current-menu-item > a,
            .hfe-nav-menu > li.current_page_item > a,
            .hfe-nav-menu > li.current-menu-ancestor > .hfe-has-submenu-container > a,
            .hfe-nav-menu > li.current-menu-parent > .hfe-has-submenu-container > a,
            .hfe-nav-menu > li.current_page_ancestor > .hfe-has-submenu-container > a,
            .hfe-nav-menu > li.current_page_parent > .hfe-has-submenu-container > a,
            .hfe-nav-menu > li.current-menu-ancestor > a,
            .hfe-nav-menu > li.current-menu-parent > a,
            .hfe-nav-menu > li.bk-nav-active > a,
            .hfe-nav-menu > li.bk-nav-active > .hfe-has-submenu-container > a {
                color: #F5B82E !important;
                background: rgba(255, 255, 255, 0.12) !important;
                box-shadow: inset 0 0 0 1px rgba(245, 184, 46, 0.35) !important;
                font-weight: 700 !important;
            }
            .hfe-nav-menu > li.current-menu-ancestor .sub-arrow,
            .hfe-nav-menu > li.current-menu-parent .sub-arrow,
            .hfe-nav-menu > li.current-menu-ancestor .sub-arrow i,
            .hfe-nav-menu > li.current-menu-parent .sub-arrow i,
            .hfe-nav-menu > li.bk-nav-active .sub-arrow,
            .hfe-nav-menu > li.bk-nav-active .sub-arrow i {
                color: #F5B82E !important;
                fill: #F5B82E !important;
            }

            /* Submenu Dropdown Panel */
            .hfe-nav-menu .sub-menu {
                background: #ffffff !important;
                border-radius: 6px !important;
                box-shadow: 0 16px 36px -4px rgba(0, 0, 0, 0.22), 0 0 0 1px rgba(0, 0, 0, 0.06) !important;
                border: none !important;
                padding: 6px !important;
                min-width: 220px !important;
                animation: bk-fade-down 0.2s cubic-bezier(0.16, 1, 0.3, 1);
                margin-top: 6px !important;
            }
            .hfe-nav-menu .sub-menu li {
                margin: 0 !important;
                padding: 0 !important;
                list-style: none !important;
                border: none !important;
            }
            .hfe-nav-menu .sub-menu li a.hfe-sub-menu-item,
            .hfe-nav-menu .sub-menu li a {
                color: #2D3748 !important;
                font-family: 'Poppins', sans-serif !important;
                font-size: 12.5px !important;
                font-weight: 500 !important;
                padding: 8px 12px !important;
                border-radius: 8px !important;
                transition: all 0.15s ease !important;
                display: flex !important;
                align-items: center !important;
                text-decoration: none !important;
                line-height: 1.35 !important;
            }
            .hfe-nav-menu .sub-menu li a:hover {
                background: #FAF8F5 !important;
                color: #0D3B22 !important;
                font-weight: 600 !important;
                padding-left: 15px !important;
            }
            /* Active Submenu Item inside Dropdown */
            .hfe-nav-menu .sub-menu li.current-menu-item > a,
            .hfe-nav-menu .sub-menu li.current_page_item > a,
            .hfe-nav-menu .sub-menu li a.hfe-sub-menu-item-active {
                background: #E8F0EA !important;
                color: #0D3B22 !important;
                font-weight: 700 !important;
                position: relative !important;
                padding-left: 18px !important;
            }
            .hfe-nav-menu .sub-menu li.current-menu-item > a::before,
            .hfe-nav-menu .sub-menu li.current_page_item > a::before,
            .hfe-nav-menu .sub-menu li a.hfe-sub-menu-item-active::before {
                content: '' !important;
                position: absolute !important;
                left: 8px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                width: 4px !important;
                height: 12px !important;
                border-radius: 2px !important;
                background: #0D3B22 !important;
            }

            .hfe-nav-menu__toggle {
                display: none !important;
            }
        }

        /* ===================================================================== */
        /* BK-CONNECT STYLE MOBILE NAVBAR & DRAWER OVERLAY                       */
        /* ===================================================================== */
        @media (max-width: 1024px) {
            /* 1. Hide Top Strip on Mobile for Clean Razor-Slim Single Navbar */
            #masthead .elementor-element-sec_top_strip,
            .elementor-element-sec_top_strip {
                display: none !important;
            }

            /* 2. Lock Main Navbar to Exactly 52px Height */
            #masthead .elementor-element-sec_main_navbar,
            .elementor-element-sec_main_navbar {
                height: 52px !important;
                min-height: 52px !important;
                max-height: 52px !important;
                padding: 0 14px !important;
                display: flex !important;
                align-items: center !important;
                background: #0D3B22 !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
                box-sizing: border-box !important;
            }
            #masthead .elementor-element-sec_main_navbar .elementor-container {
                height: 52px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                width: 100% !important;
            }

            /* 3. Reset menu column ancestors so toggle stays cleanly on right */
            .elementor-element-col_menu,
            .elementor-element-col_menu .elementor-widget-wrap,
            .elementor-element-w_nav_menu,
            .elementor-element-w_nav_menu .elementor-widget-container,
            .elementor-element-col_menu .hfe-nav-menu {
                position: static !important;
                margin-left: auto !important;
            }

            /* 4. Hamburger Toggle Button - Clean Gold/White in Top Right of Navbar */
            .hfe-nav-menu__toggle {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 38px !important;
                height: 38px !important;
                padding: 0 !important;
                margin-left: auto !important;
                margin-right: 0 !important;
                background: rgba(255, 255, 255, 0.08) !important;
                border: 1px solid rgba(255, 255, 255, 0.2) !important;
                border-radius: 9px !important;
                cursor: pointer !important;
                color: #ffffff !important;
                transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
                z-index: 1000005 !important;
                flex-shrink: 0 !important;
                align-self: center !important;
                position: relative !important;
            }
            .hfe-nav-menu__toggle:hover {
                background: rgba(245, 184, 46, 0.22) !important;
                border-color: #F5B82E !important;
            }
            .hfe-nav-menu__toggle .hfe-nav-menu-icon {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 100% !important;
                height: 100% !important;
            }
            .hfe-nav-menu__toggle svg {
                fill: #ffffff !important;
                color: #ffffff !important;
                width: 20px !important;
                height: 20px !important;
                display: block !important;
            }

            /* Active State: Hamburger Button transforms into Gold Silang (✕) */
            body.bk-menu-open .hfe-nav-menu__toggle,
            .hfe-nav-menu__toggle.hfe-active-menu {
                background: rgba(245, 184, 46, 0.22) !important;
                border: 1.5px solid #F5B82E !important;
                box-shadow: 0 0 14px rgba(245, 184, 46, 0.4) !important;
            }
            body.bk-menu-open .hfe-nav-menu__toggle svg,
            .hfe-nav-menu__toggle.hfe-active-menu svg {
                display: none !important;
            }
            body.bk-menu-open .hfe-nav-menu__toggle .hfe-nav-menu-icon::before,
            .hfe-nav-menu__toggle.hfe-active-menu .hfe-nav-menu-icon::before {
                content: '✕' !important;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
                font-size: 20px !important;
                font-weight: 700 !important;
                color: #F5B82E !important;
                display: block !important;
                line-height: 1 !important;
                text-align: center !important;
                width: 20px !important;
                height: 20px !important;
            }

            /* 5. Mobile Menu Drawer Container (Directly Beneath Fixed Header) */
            nav.hfe-nav-menu__layout-horizontal {
                position: fixed !important;
                top: 52px !important;
                left: 0 !important;
                right: 0 !important;
                width: 100vw !important;
                max-width: 100vw !important;
                height: calc(100vh - 52px) !important;
                height: calc(100dvh - 52px) !important;
                max-height: calc(100dvh - 52px) !important;
                background: #0D3B22 !important;
                background-color: #0D3B22 !important;
                border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
                z-index: 999998 !important;
                display: flex !important;
                flex-direction: column !important;
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch !important;
                padding: 12px 18px 40px 18px !important;
                margin: 0 !important;
                box-sizing: border-box !important;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5) !important;
                
                /* Default Closed State */
                visibility: hidden !important;
                opacity: 0 !important;
                pointer-events: none !important;
                transform: translateY(-8px) !important;
                transition: opacity 0.22s cubic-bezier(0.16, 1, 0.3, 1), transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.22s !important;
            }

            body.admin-bar nav.hfe-nav-menu__layout-horizontal {
                top: 84px !important;
                height: calc(100dvh - 84px) !important;
            }
            @media screen and (max-width: 782px) {
                body.admin-bar nav.hfe-nav-menu__layout-horizontal {
                    top: 98px !important;
                    height: calc(100dvh - 98px) !important;
                }
            }

            /* 6. Active / Open State */
            body.bk-menu-open nav.hfe-nav-menu__layout-horizontal,
            nav.hfe-nav-menu__layout-horizontal.bk-canvas-open,
            nav.hfe-nav-menu__layout-horizontal.menu-is-active {
                visibility: visible !important;
                opacity: 1 !important;
                pointer-events: auto !important;
                transform: translateY(0) !important;
            }

            /* Inner menu list visibility */
            body.bk-menu-open nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu,
            nav.hfe-nav-menu__layout-horizontal.bk-canvas-open .hfe-nav-menu,
            nav.hfe-nav-menu__layout-horizontal.menu-is-active .hfe-nav-menu {
                visibility: visible !important;
                opacity: 1 !important;
                display: flex !important;
                flex-direction: column !important;
            }

            /* 7. Hide duplicate topbar */
            .bk-canvas-topbar {
                display: none !important;
            }

            /* 8. Eliminate white boxes */
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu li,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu li a,
            nav.hfe-nav-menu__layout-horizontal .hfe-has-submenu-container,
            nav.hfe-nav-menu__layout-horizontal .hfe-dropdown,
            nav.hfe-nav-menu__layout-horizontal .hfe-dropdown li,
            nav.hfe-nav-menu__layout-horizontal .hfe-dropdown a {
                background: transparent !important;
                background-color: transparent !important;
                box-shadow: none !important;
                border-color: transparent;
            }

            /* 9. Menu Items List inside Drawer */
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu {
                display: flex !important;
                flex-direction: column !important;
                width: 100% !important;
                padding: 4px 0 16px 0 !important;
                margin: 0 !important;
                list-style: none !important;
                box-sizing: border-box !important;
                flex-grow: 1 !important;
            }

            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
                background: transparent !important;
            }
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li:last-child {
                border-bottom: none !important;
            }

            /* Main Menu Link Text & Dropdown Triggers */
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li > a,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li .hfe-has-submenu-container,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li .hfe-has-submenu-container > a {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                width: 100% !important;
                padding: 13px 4px !important;
                font-family: 'Poppins', sans-serif !important;
                font-size: 15px !important;
                font-weight: 500 !important;
                color: #ffffff !important;
                background: transparent !important;
                background-color: transparent !important;
                border: none !important;
                border-radius: 0 !important;
                text-decoration: none !important;
                box-sizing: border-box !important;
                transition: color 0.15s ease !important;
                cursor: pointer !important;
            }

            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li > a:hover,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.current-menu-item > a,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.current-menu-ancestor > .hfe-has-submenu-container,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.current-menu-ancestor > .hfe-has-submenu-container > a,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.current-menu-parent > .hfe-has-submenu-container,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.current-menu-parent > .hfe-has-submenu-container > a,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.bk-nav-active > a,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.bk-nav-active > .hfe-has-submenu-container,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.bk-nav-active > .hfe-has-submenu-container > a,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li .hfe-has-submenu-container:hover,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.menu-active > .hfe-has-submenu-container,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.menu-active > .hfe-has-submenu-container > a {
                color: #F5B82E !important;
            }
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.current-menu-item > a,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.current-menu-ancestor > .hfe-has-submenu-container > a,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.current-menu-parent > .hfe-has-submenu-container > a,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.bk-nav-active > a,
            nav.hfe-nav-menu__layout-horizontal .hfe-nav-menu > li.bk-nav-active > .hfe-has-submenu-container > a {
                font-weight: 700 !important;
            }

            /* Submenu Arrow (Chevron) */
            nav.hfe-nav-menu__layout-horizontal .sub-arrow,
            nav.hfe-nav-menu__layout-horizontal .hfe-menu-toggle {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 32px !important;
                height: 32px !important;
                border-radius: 8px !important;
                background: rgba(255, 255, 255, 0.08) !important;
                color: #F5B82E !important;
                margin-left: auto !important;
                transition: transform 0.25s ease, background 0.2s ease !important;
                pointer-events: none !important;
            }
            nav.hfe-nav-menu__layout-horizontal .sub-arrow i,
            nav.hfe-nav-menu__layout-horizontal .sub-arrow svg {
                fill: #F5B82E !important;
                color: #F5B82E !important;
                font-size: 14px !important;
            }
            nav.hfe-nav-menu__layout-horizontal .menu-active .sub-arrow,
            nav.hfe-nav-menu__layout-horizontal .sub-menu-active .sub-arrow {
                transform: rotate(180deg) !important;
                background: rgba(245, 184, 46, 0.25) !important;
            }

            /* Submenu Accordion Drawer */
            nav.hfe-nav-menu__layout-horizontal .sub-menu {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                height: 0 !important;
                overflow: hidden !important;
            }
            nav.hfe-nav-menu__layout-horizontal .sub-menu.sub-menu-open,
            nav.hfe-nav-menu__layout-horizontal .sub-menu.bk-sub-open,
            nav.hfe-nav-menu__layout-horizontal .menu-active > .sub-menu {
                display: flex !important;
                flex-direction: column !important;
                visibility: visible !important;
                opacity: 1 !important;
                height: auto !important;
                overflow: visible !important;
                background: rgba(0, 0, 0, 0.3) !important;
                border-radius: 6px !important;
                padding: 6px 12px !important;
                margin: 4px 0 12px 0 !important;
                border-left: 3px solid #F5B82E !important;
                border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
                border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
                list-style: none !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
            nav.hfe-nav-menu__layout-horizontal .sub-menu li {
                width: 100% !important;
                list-style: none !important;
                margin: 0 !important;
                padding: 0 !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
                background: transparent !important;
                background-color: transparent !important;
            }
            nav.hfe-nav-menu__layout-horizontal .sub-menu li:last-child {
                border-bottom: none !important;
            }
            nav.hfe-nav-menu__layout-horizontal .sub-menu li a {
                display: block !important;
                width: 100% !important;
                padding: 10px 6px !important;
                font-family: 'Poppins', sans-serif !important;
                font-size: 13.5px !important;
                font-weight: 400 !important;
                color: rgba(255, 255, 255, 0.85) !important;
                text-decoration: none !important;
                background: transparent !important;
                background-color: transparent !important;
                border: none !important;
                box-sizing: border-box !important;
                transition: all 0.15s ease !important;
            }
            nav.hfe-nav-menu__layout-horizontal .sub-menu li a:hover,
            nav.hfe-nav-menu__layout-horizontal .sub-menu li a:active {
                color: #F5B82E !important;
                padding-left: 12px !important;
                background: transparent !important;
            }

            /* 10. Bottom Action Card inside Drawer (BK-Connect Masuk Portal Button) */
            .bk-canvas-bottom-card {
                padding: 16px 4px 28px 4px !important;
                margin-top: auto !important;
                width: 100% !important;
                box-sizing: border-box !important;
                border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
                flex-shrink: 0 !important;
            }
            .bk-canvas-portal-btn {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 100% !important;
                padding: 12px 20px !important;
                background: #F5B82E !important;
                color: #0D3B22 !important;
                font-family: 'Poppins', sans-serif !important;
                font-size: 14px !important;
                font-weight: 700 !important;
                text-decoration: none !important;
                border-radius: 30px !important;
                box-shadow: 0 8px 24px rgba(245, 184, 46, 0.35) !important;
                box-sizing: border-box !important;
                transition: transform 0.2s ease, box-shadow 0.2s ease !important;
            }
            .bk-canvas-portal-btn:active {
                transform: scale(0.98) !important;
            }
        }

        body.bk-menu-open {
            overflow: hidden !important;
        }

        @keyframes bk-canvas-fade {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Mobile specific adjustments (<480px) */
        @media (max-width: 480px) {
            .elementor-element-col_brand span {
                display: none !important; /* Hide long subtitle on tiny screens for ultra clean navbar */
            }
            .elementor-element-sec_top_strip .bk-portal-desc {
                display: none !important; /* On tiny phones, show just Portal badge + Masuk Portal */
            }
            .elementor-element-sec_top_strip div {
                gap: 4px !important;
            }
        }

        /* Responsive Column Breakpoints (Tablets & Phones < 900px) */
        @media (max-width: 900px) {
            .elementor-element-col_hero_left,
            .elementor-element-col_hero_right,
            .elementor-element-col_about_left,
            .elementor-element-col_about_right,
            .elementor-element-col_cta_left,
            .elementor-element-col_cta_right {
                width: 100% !important;
                flex: 0 0 100% !important;
                max-width: 100% !important;
            }
            .elementor-element-col_hero_right,
            .elementor-element-col_about_right,
            .elementor-element-col_cta_right {
                margin-top: 24px !important;
            }
        }

        /* ===================================================================== */
        /* RESPONSIVE LAYOUT & ULTRA-SLIM GUTTERS (MARGIN TIPIS KIRI KANAN)      */
        /* ===================================================================== */
        .elementor-section {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        .elementor-section.elementor-section-boxed > .elementor-container,
        .elementor-section.elementor-section-full_width > .elementor-container {
            max-width: 100% !important;
            width: 100% !important;
            padding-left: clamp(10px, 2vw, 24px) !important;
            padding-right: clamp(10px, 2vw, 24px) !important;
            box-sizing: border-box !important;
        }

        /* Mobile Gutters & Spacing (<768px) - Margin Tipis Mepet ke Tepi Layar */
        @media (max-width: 768px) {
            .elementor-section.elementor-section-boxed > .elementor-container,
            .elementor-section.elementor-section-full_width > .elementor-container {
                padding-left: 10px !important;
                padding-right: 10px !important;
                box-sizing: border-box !important;
            }

            /* Header Top Strip & Main Navbar Padding (Balanced ~46px height with clean 14px side gutters) */
            #masthead,
            #masthead .elementor-section {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            #masthead .elementor-element-sec_top_strip,
            .elementor-element-sec_top_strip {
                padding-top: 2px !important;
                padding-bottom: 2px !important;
                padding-left: 14px !important;
                padding-right: 14px !important;
                min-height: unset !important;
                height: auto !important;
                max-height: 24px !important;
                box-sizing: border-box !important;
            }
            #masthead .elementor-element-sec_main_navbar,
            .elementor-element-sec_main_navbar {
                padding-top: 7px !important;
                padding-bottom: 7px !important;
                padding-left: 14px !important;
                padding-right: 14px !important;
                min-height: unset !important;
                height: auto !important;
                box-sizing: border-box !important;
            }

            /* Only body content sections get vertical spacing */
            .elementor-section:not(#masthead .elementor-section):not(.elementor-element-sec_top_strip):not(.elementor-element-sec_main_navbar):not(#colophon .elementor-section) {
                padding-left: 0 !important;
                padding-right: 0 !important;
                padding-top: 26px !important;
                padding-bottom: 28px !important;
            }
            #hero_section {
                padding-top: 18px !important;
                padding-bottom: 22px !important;
            }
            /* Fluid mobile headings */
            h1, .elementor-element-hero_section h1 {
                font-size: clamp(24px, 6.8vw, 34px) !important;
                line-height: 1.2 !important;
                letter-spacing: -0.02em !important;
            }
            h2 {
                font-size: clamp(19px, 5.5vw, 26px) !important;
                line-height: 1.25 !important;
                letter-spacing: -0.02em !important;
            }
            h3 {
                font-size: 16px !important;
            }
            p {
                font-size: 13px !important;
                line-height: 1.55 !important;
            }

            /* Hero CTAs full width stack on phone */
            .bk-hero-cta-wrap {
                flex-direction: column !important;
                width: 100% !important;
                gap: 10px !important;
            }
            .bk-hero-cta-wrap a {
                width: 100% !important;
                justify-content: center !important;
            }

            /* Hero Floating Box on Mobile */
            .bk-float {
                margin-top: 24px !important;
                padding: 22px 18px !important;
            }

            /* About section stack */
            .elementor-element-col_about_right {
                margin-top: 24px !important;
            }
        }

        /* ===================================================================== */
        /* RESPONSIVE GRID SYSTEMS (Mobile 1-Column, Tablet 2-Column)            */
        /* ===================================================================== */
        @media (max-width: 991px) {
            .bk-prodi-grid,
            .bk-lulusan-grid,
            .bk-lab-grid,
            .bk-news-grid {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }
            .bk-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 16px !important;
            }
        }
        @media (max-width: 480px) {
            .bk-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 12px !important;
            }
            .bk-stats-grid > div > div:nth-child(2) {
                font-size: 28px !important;
            }
        }

        /* ===================================================================== */
        /* DOSEN MARQUEE CAROUSEL MOBILE TWEAKS                                  */
        /* ===================================================================== */
        @media (max-width: 640px) {
            #bk-dosen-left,
            #bk-dosen-right {
                width: 32px !important;
                padding: 0 4px !important;
            }
            #bk-dosen-left svg,
            #bk-dosen-right svg {
                width: 20px !important;
                height: 20px !important;
            }
            #bk-dosen-track > div {
                flex: 0 0 260px !important;
                padding: 18px 16px !important;
            }
        }

        /* ===================================================================== */
        /* FOOTER MOBILE RESPONSIVENESS                                          */
        /* ===================================================================== */
        @media (max-width: 768px) {
            .elementor-element-sec_footer .elementor-container {
                flex-direction: column !important;
                gap: 24px !important;
            }
            .elementor-element-col_footer_brand,
            .elementor-element-col_footer_prodi,
            .elementor-element-col_footer_links {
                width: 100% !important;
                padding: 0 !important;
            }
            .elementor-element-sec_bottom_strip div {
                flex-direction: column !important;
                text-align: center !important;
                gap: 8px !important;
            }
        }

        /* ===================================================================== */
        /* MOTION ENGINE: PHYSICS & HOVER TRANSITIONS                            */
        /* ===================================================================== */
        .bk-motion-reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .bk-motion-reveal.bk-in-view {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }

        .bk-card-hover {
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1) !important;
            will-change: transform, box-shadow;
        }
        @media (hover: hover) {
            .bk-card-hover:hover {
                transform: translateY(-6px) !important;
                box-shadow: 0 20px 38px -8px rgba(13, 59, 34, 0.14), 0 0 0 1px rgba(13, 59, 34, 0.16) !important;
            }
            .bk-btn-hover:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 14px 26px -6px rgba(245, 184, 46, 0.45) !important;
            }
        }
        .bk-btn-hover {
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
            will-change: transform, box-shadow;
        }
        .bk-btn-hover:active {
            transform: translateY(0px) scale(0.97) !important;
        }

        @keyframes bk-pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.35; transform: scale(0.8); }
        }
        .bk-pulse-dot {
            display: inline-block;
            animation: bk-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite !important;
            will-change: opacity, transform;
        }

        @keyframes bk-float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-7px); }
        }
        .bk-float {
            animation: bk-float 4.5s ease-in-out infinite !important;
            will-change: transform;
        }

        @keyframes bk-fade-down {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none !important;
        }
        .no-scrollbar {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }

        /* ===================================================================== */
        /* SCHOLARO PROFIL, AKADEMIK & KEMAHASISWAAN SUITE STYLING               */
        /* ===================================================================== */
        
        /* Force Astra full-width on Elementor pages (Zero unwanted gutters) */
        .elementor-template-full-width .ast-container,
        .elementor-page .ast-container {
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        .elementor-template-full-width #content.site-content,
        .elementor-page #content.site-content {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }
        .elementor-template-full-width .entry-content,
        .elementor-page .entry-content {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        /* 1. Kapsul Menu Navigasi Submenu (Identik dengan Profil & Akademik) */
        .bk-subnav-sticky-wrap {
            position: relative !important;
            z-index: 45 !important;
            margin-top: -28px !important;
            margin-bottom: 30px !important;
            padding: 0 var(--bk-edge-pad, 1rem) !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }
        .bk-subnav-sticky-wrap > div {
            background: #ffffff !important;
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(14px) !important;
            -webkit-backdrop-filter: blur(14px) !important;
            border: 1px solid #D4E3D8 !important;
            border-radius: 18px !important;
            box-shadow: 0 8px 24px -4px rgba(13, 59, 34, 0.08), 0 2px 6px rgba(13, 59, 34, 0.04) !important;
            padding: 6px 8px !important;
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 auto !important;
            box-sizing: border-box !important;
        }
        .bk-subnav-sticky-wrap ul {
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            margin: 0 !important;
            padding: 0 !important;
            white-space: nowrap !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            list-style: none !important;
        }
        .bk-subnav-sticky-wrap li {
            flex-shrink: 0 !important;
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .bk-subnav-item {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            padding: 7px 14px !important;
            border-radius: 6px !important;
            font-size: 12px !important;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 500 !important;
            color: #4B5563 !important;
            text-decoration: none !important;
            background: transparent !important;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
            white-space: nowrap !important;
            flex-shrink: 0 !important;
        }
        .bk-subnav-item:hover {
            background: #E8F0EA !important;
            color: #0D3B22 !important;
        }
        .bk-subnav-item.bk-active {
            background: #0D3B22 !important;
            color: #F5B82E !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 12px rgba(13, 59, 34, 0.22) !important;
        }
        .bk-subnav-item.bk-active:hover {
            background: #0D3B22 !important;
            color: #F5B82E !important;
        }

        /* In-Page Tab Switcher for Statistik */
        .bk-stat-tabs-container {
            background: #ffffff !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 18px !important;
            padding: 5px !important;
            max-width: 560px !important;
            width: 100% !important;
            box-sizing: border-box !important;
            margin: 0 auto 32px !important;
            box-shadow: 0 4px 16px -4px rgba(13, 59, 34, 0.06) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 6px !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }
        .bk-stat-tab-btn {
            flex: 1 1 0 !important;
            padding: 9px 12px !important;
            border-radius: 13px !important;
            font-size: 12px !important;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            border: none !important;
            background: transparent !important;
            color: #4B5563 !important;
            text-align: center !important;
            white-space: nowrap !important;
            transition: all 0.2s ease !important;
        }
        .bk-stat-tab-btn:hover {
            background: #F1F5F9 !important;
            color: #0F172A !important;
        }
        .bk-stat-tab-btn.active {
            background: #0D3B22 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            box-shadow: 0 3px 10px rgba(13, 59, 34, 0.18) !important;
        }
        @media (max-width: 560px) {
            .bk-stat-tabs-container {
                justify-content: flex-start !important;
                border-radius: 6px !important;
                padding: 4px !important;
            }
            .bk-stat-tab-btn {
                flex: 0 0 auto !important;
                padding: 7px 12px !important;
                font-size: 11px !important;
            }
        }

        /* 2. Scholaro Authentic Hero */
        .bk-hero-kemahasiswaan {
            position: relative !important;
            overflow: hidden !important;
            background: #0D3B22 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            padding: var(--bk-top-clearance, 36px) 0 60px !important;
            font-family: 'Poppins', sans-serif !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        .bk-hero-kemahasiswaan .orb-1 {
            position: absolute !important;
            top: -100px !important;
            right: -10% !important;
            width: 500px !important;
            height: 500px !important;
            border-radius: 50% !important;
            background: rgba(24, 83, 51, 0.35) !important;
            filter: blur(80px) !important;
            pointer-events: none !important;
        }
        .bk-hero-kemahasiswaan .orb-2 {
            position: absolute !important;
            bottom: -120px !important;
            left: -10% !important;
            width: 450px !important;
            height: 450px !important;
            border-radius: 50% !important;
            background: rgba(245, 184, 46, 0.12) !important;
            filter: blur(90px) !important;
            pointer-events: none !important;
        }
        .bk-hero-kemahasiswaan .dot-grid {
            position: absolute !important;
            inset: 0 !important;
            background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px) !important;
            background-size: 24px 24px !important;
            pointer-events: none !important;
            opacity: 0.45 !important;
        }
        .bk-hero-kemahasiswaan .hero-badge {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 5px 14px !important;
            border-radius: 6px !important;
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #F5B82E !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            letter-spacing: 0.08em !important;
            text-transform: uppercase !important;
            margin-bottom: 18px !important;
        }
        .bk-hero-kemahasiswaan h1 {
            font-family: 'Fraunces', Georgia, serif !important;
            font-size: clamp(28px, 4.2vw, 48px) !important;
            font-weight: 500 !important;
            line-height: 1.2 !important;
            color: #ffffff !important;
            margin: 0 0 16px 0 !important;
            max-width: 900px !important;
            letter-spacing: -0.02em !important;
        }
        .bk-hero-kemahasiswaan p.hero-desc {
            font-size: clamp(14px, 1.5vw, 16px) !important;
            line-height: 1.7 !important;
            color: rgba(255, 255, 255, 0.85) !important;
            margin: 0 0 24px 0 !important;
            max-width: 760px !important;
            font-weight: 400 !important;
        }
        .bk-hero-grid {
            display: grid !important;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)) !important;
            gap: 14px !important;
            max-width: 820px !important;
            margin-top: 24px !important;
        }
        .bk-hero-card {
            background: rgba(255, 255, 255, 0.08) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            border-radius: 8px !important;
            padding: 16px 20px !important;
            color: #ffffff !important;
            overflow: hidden !important;
            box-sizing: border-box !important;
        }
        .bk-hero-card .card-label {
            font-size: 11px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.06em !important;
            font-weight: 700 !important;
            color: rgba(255, 255, 255, 0.7) !important;
            display: block !important;
            margin-bottom: 6px !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }
        .bk-hero-card .card-value {
            font-family: 'Fraunces', Georgia, serif !important;
            font-size: 28px !important;
            font-weight: 700 !important;
            line-height: 1 !important;
            display: block !important;
        }
        .bk-hero-card .card-value.gold {
            color: #F5B82E !important;
        }
        .bk-hero-card .card-value.white {
            color: #ffffff !important;
        }
        .bk-hero-card .card-sub {
            font-size: 11px !important;
            color: rgba(255, 255, 255, 0.65) !important;
            margin-top: 6px !important;
            margin-bottom: 0 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        /* 3. In-Page Filter & Tab Toolbars (Kapsul Toolbar) */
        .ppb-toolbar-wrap {
            background: #ffffff !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 8px !important;
            padding: 16px 20px !important;
            box-shadow: 0 8px 24px -6px rgba(13, 59, 34, 0.06) !important;
            margin-bottom: 28px !important;
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 14px !important;
        }
        .ppb-pill-btn {
            padding: 8px 16px !important;
            border-radius: 6px !important;
            font-size: 12.5px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            border: 1px solid #E2E8F0 !important;
            background: #FAF8F5 !important;
            color: #475569 !important;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
            white-space: nowrap !important;
            flex-shrink: 0 !important;
        }
        .ppb-pill-btn:hover {
            background: #E8F0EA !important;
            color: #0D3B22 !important;
        }
        .ppb-pill-btn.active {
            background: #0D3B22 !important;
            color: #F5B82E !important;
            border-color: #0D3B22 !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 12px rgba(13, 59, 34, 0.18) !important;
        }
        .ppb-search-input {
            width: 100% !important;
            box-sizing: border-box !important;
            padding: 9px 14px 9px 36px !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 6px !important;
            font-size: 12.5px !important;
            background: #FAF8F5 !important;
            color: #1e293b !important;
            outline: none !important;
            transition: all 0.2s ease !important;
        }
        .ppb-search-input:focus {
            border-color: #0D3B22 !important;
            background: #ffffff !important;
            box-shadow: 0 0 0 3px rgba(13, 59, 34, 0.1) !important;
        }
        .ppb-select-year {
            padding: 9px 14px !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 6px !important;
            font-size: 12.5px !important;
            font-weight: 600 !important;
            background: #FAF8F5 !important;
            color: #334155 !important;
            outline: none !important;
            cursor: pointer !important;
        }
        .ppb-select-year:focus {
            border-color: #0D3B22 !important;
            box-shadow: 0 0 0 3px rgba(13, 59, 34, 0.1) !important;
        }

        /* 4. Card Styling */
        .ppb-card-item {
            background: #ffffff !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 8px !important;
            padding: 24px !important;
            box-shadow: 0 6px 20px -4px rgba(13, 59, 34, 0.05) !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        .ppb-card-item:hover {
            transform: translateY(-4px) !important;
            border-color: rgba(13, 59, 34, 0.3) !important;
            box-shadow: 0 16px 32px -8px rgba(13, 59, 34, 0.1) !important;
        }

        /* Mobile Adjustments */
        @media (max-width: 767px) {
            .bk-subnav-sticky-wrap {
                margin-top: -20px !important;
                padding: 0 10px !important;
                margin-bottom: 22px !important;
                justify-content: flex-start !important;
            }
            .bk-subnav-sticky-wrap > div,
            .bk-subnav-capsule {
                border-radius: 6px !important;
                padding: 4px 6px !important;
                width: auto !important;
                justify-content: flex-start !important;
            }
            .bk-subnav-item {
                padding: 6px 13px !important;
                font-size: 11.5px !important;
            }
            .ppb-toolbar-wrap {
                padding: 12px 14px !important;
                border-radius: 18px !important;
            }
            .bk-hero-grid {
                grid-template-columns: 1fr 1fr !important;
                gap: 10px !important;
            }
            .bk-hero-card {
                padding: 12px 14px !important;
                border-radius: 6px !important;
            }
            .bk-hero-card .card-value {
                font-size: 22px !important;
            }
        }

        /* ===================================================================== */
        /* SCHOLARO ZERO-GAP FULL-BLEED SUITE RESET (PROFIL, AKADEMIK, KEMHS, LYN) */
        /* ===================================================================== */
        .page-header {
            display: none !important;
        }
        .site-main, #content, .page-content, .entry-content {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        .bk-page-wrapper {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #FAF8F5 !important;
            box-sizing: border-box !important;
        }
        .elementor-section:has(.bk-hero-kemahasiswaan),
        .elementor-section:has(.bk-page-wrapper),
        .elementor-section:has(section[style*=\'background:#0D3B22\']),
        .elementor-section:has(section[style*=\'background: #0D3B22\']) {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            margin: 0 !important;
        }
        .elementor-section-full_width:has(.bk-hero-kemahasiswaan) > .elementor-container,
        .elementor-section-full_width:has(.bk-page-wrapper) > .elementor-container,
        .elementor-section-full_width:has(section[style*=\'background:#0D3B22\']) > .elementor-container,
        .elementor-section-full_width:has(section[style*=\'background: #0D3B22\']) > .elementor-container {
            padding-left: 0 !important;
            padding-right: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
        }
    ";
    wp_add_inline_style('bk-fonts', $custom_css);
}
}
add_action('wp_enqueue_scripts', 'bk_enqueue_scholaro_fonts', 20);
add_action('elementor/frontend/after_enqueue_styles', 'bk_enqueue_scholaro_fonts');

/**
 * Global Motion Engine Scripts (Scroll-Reveal Observer & Infinite Dosen Carousel Engine)
 */
if (!function_exists('bk_enqueue_motion_engine_scripts')) {
function bk_enqueue_motion_engine_scripts() {
    ?>
    <script id="bk-motion-engine">
    (function() {
        function initMotionEngine() {
            // 0. Sticky Header Scroll Listener & Height Synchronizer
            var masthead = document.getElementById('masthead') || document.querySelector('.elementor-hf-header');
            if (masthead) {
                function syncHeaderHeight() {
                    var h = masthead.getBoundingClientRect().height;
                    if (h > 0) {
                        var exactH = Math.round(h);
                        document.documentElement.style.setProperty('--ppb-navbar-height', exactH + 'px');
                        // padding-top handled by #bk-navbar-spacer
                    }
                }
                syncHeaderHeight();
                window.addEventListener('resize', syncHeaderHeight, { passive: true });

                function onScroll() {
                    if (window.scrollY > 20) {
                        masthead.classList.add('bk-scrolled');
                    } else {
                        masthead.classList.remove('bk-scrolled');
                    }
                }
                window.addEventListener('scroll', onScroll, { passive: true });
                onScroll();

                // Active Navbar State Resolver (ensures parent & child menus light up on active section)
                function highlightActiveNavbarItem() {
                    var path = window.location.pathname.replace(/\/+$/, '') || '/';
                    var menuItems = document.querySelectorAll('.hfe-nav-menu > li');
                    menuItems.forEach(function(li) {
                        var subLinks = li.querySelectorAll('.sub-menu a');
                        var isChildActive = false;
                        subLinks.forEach(function(subA) {
                            var subHref = subA.getAttribute('href');
                            if (subHref) {
                                try {
                                    var subUrl = new URL(subHref, window.location.origin);
                                    var subPath = subUrl.pathname.replace(/\/+$/, '');
                                    if (subPath && path === subPath) {
                                        isChildActive = true;
                                        subA.classList.add('hfe-sub-menu-item-active');
                                        var subLi = subA.closest('li');
                                        if (subLi) subLi.classList.add('current-menu-item');
                                    }
                                } catch(e) {}
                            }
                        });

                        var pathPrefixMap = {
                            '/profil': ['menu-item-39'],
                            '/akademik': ['menu-item-46'],
                            '/kemahasiswaan': ['menu-item-51'],
                            '/layanan': ['menu-item-55'],
                            '/lab-bk': ['menu-item-55'],
                            '/survei': ['menu-item-55'],
                            '/berita': ['menu-item-62']
                        };

                        for (var prefix in pathPrefixMap) {
                            if (path.indexOf(prefix) === 0 && pathPrefixMap[prefix].indexOf(li.id) !== -1) {
                                isChildActive = true;
                                break;
                            }
                        }

                        if (isChildActive) {
                            li.classList.add('current-menu-ancestor');
                            li.classList.add('current-menu-parent');
                            li.classList.add('bk-nav-active');
                        }
                    });
                }
                highlightActiveNavbarItem();
            }

            // Mobile Menu Controller (BK-Connect Drawer Style)
            var navEl = document.querySelector('nav.hfe-nav-menu__layout-horizontal');
            var toggleBtn = document.querySelector('.hfe-nav-menu__toggle');

            function openMobileMenu() {
                if (navEl) {
                    navEl.classList.add('bk-canvas-open');
                    navEl.classList.add('menu-is-active');
                }
                if (toggleBtn) {
                    toggleBtn.classList.add('hfe-active-menu');
                    toggleBtn.setAttribute('aria-expanded', 'true');
                }
                document.body.classList.add('bk-menu-open');
                document.body.style.overflow = 'hidden';
            }

            function closeMobileMenu() {
                if (navEl) {
                    navEl.classList.remove('bk-canvas-open');
                    navEl.classList.remove('menu-is-active');
                }
                if (toggleBtn) {
                    toggleBtn.classList.remove('hfe-active-menu');
                    toggleBtn.classList.remove('hfe-active-menu-full-width');
                    toggleBtn.setAttribute('aria-expanded', 'false');
                }
                document.body.classList.remove('bk-menu-open');
                document.body.style.overflow = '';
            }

            if (navEl) {
                // Injected Bottom Action Card (BK-Connect Masuk Portal Button)
                if (!navEl.querySelector('.bk-canvas-bottom-card')) {
                    var bottomCard = document.createElement('div');
                    bottomCard.className = 'bk-canvas-bottom-card';
                    bottomCard.innerHTML = '<a href="https://bk-connect-fipunm.vercel.app/auth" target="_blank" rel="noopener" class="bk-canvas-portal-btn">' +
                        'Masuk Portal BK Connect &rarr;' +
                    '</a>' +
                    '<div style="text-align:center;font-size:10.5px;color:rgba(255,255,255,0.55);line-height:1.5;margin-top:10px;">' +
                        'Jurusan Psikologi Pendidikan dan Bimbingan<br>Fakultas Ilmu Pendidikan &middot; Universitas Negeri Makassar' +
                    '</div>';
                    navEl.appendChild(bottomCard);
                }

                // Submenu accordion click handlers
                var parentItems = navEl.querySelectorAll('.menu-item-has-children');
                parentItems.forEach(function(item) {
                    var trigger = item.querySelector('.hfe-has-submenu-container') || item.querySelector('a');
                    var subMenu = item.querySelector('.sub-menu');
                    if (trigger && subMenu) {
                        trigger.addEventListener('click', function(e) {
                            var href = trigger.getAttribute('href');
                            if (!href || href === '#' || href === '' || e.target.closest('.sub-arrow') || e.target.closest('.hfe-menu-toggle')) {
                                e.preventDefault();
                                e.stopPropagation();
                                e.stopImmediatePropagation();
                                var isSubOpen = item.classList.contains('menu-active') || subMenu.classList.contains('sub-menu-open') || subMenu.classList.contains('bk-sub-open');
                                if (isSubOpen) {
                                    item.classList.remove('menu-active');
                                    subMenu.classList.remove('sub-menu-open');
                                    subMenu.classList.remove('bk-sub-open');
                                } else {
                                    parentItems.forEach(function(other) {
                                        if (other !== item) {
                                            other.classList.remove('menu-active');
                                            var otherSub = other.querySelector('.sub-menu');
                                            if (otherSub) {
                                                otherSub.classList.remove('sub-menu-open');
                                                otherSub.classList.remove('bk-sub-open');
                                            }
                                        }
                                    });
                                    item.classList.add('menu-active');
                                    subMenu.classList.add('sub-menu-open');
                                    subMenu.classList.add('bk-sub-open');
                                }
                            }
                        }, true);
                    }
                });

                // Close menu when tapping any page/anchor link
                navEl.addEventListener('click', function(e) {
                    var link = e.target.closest('a');
                    if (link) {
                        var href = link.getAttribute('href');
                        if (href && href !== '#' && !link.closest('.hfe-has-submenu-container')) {
                            closeMobileMenu();
                        }
                    }
                });
            }

            if (toggleBtn) {
                // Use capture phase and stopImmediatePropagation to cleanly override HFE's listener
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    if (document.body.classList.contains('bk-menu-open') || (navEl && navEl.classList.contains('bk-canvas-open'))) {
                        closeMobileMenu();
                    } else {
                        openMobileMenu();
                    }
                }, true);

                // Close menu on outside click
                document.addEventListener('click', function(e) {
                    if (document.body.classList.contains('bk-menu-open')) {
                        if (navEl && !navEl.contains(e.target) && toggleBtn && !toggleBtn.contains(e.target)) {
                            closeMobileMenu();
                        }
                    }
                });

                // Close menu on Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && document.body.classList.contains('bk-menu-open')) {
                        closeMobileMenu();
                    }
                });

                // Close menu on desktop resize
                window.addEventListener('resize', function() {
                    if (window.innerWidth > 1024 && document.body.classList.contains('bk-menu-open')) {
                        closeMobileMenu();
                    }
                }, { passive: true });
            }

            // 1. Scroll-Reveal Observer (Next.js Framer Motion replica)
            var targets = document.querySelectorAll(
                '.elementor-section:not(#masthead):not(#colophon):not(.elementor-element-sec_main_navbar) .bk-card-hover, ' +
                '.elementor-section:not(#masthead):not(#colophon):not(.elementor-element-sec_main_navbar) .elementor-widget-html, ' +
                '.bk-reveal'
            );

            if ('IntersectionObserver' in window && targets.length > 0) {
                var observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('bk-in-view');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.08,
                    rootMargin: '0px 0px -30px 0px'
                });

                targets.forEach(function(el, idx) {
                    var inHero = el.closest('#hero_section');
                    if (!inHero) {
                        el.classList.add('bk-motion-reveal');
                        observer.observe(el);
                    }
                });
            }

            // 2. Continuous Auto-Scrolling Dosen Carousel Engine
            var track = document.getElementById("bk-dosen-track");
            var btnLeft = document.getElementById("bk-dosen-left");
            var btnRight = document.getElementById("bk-dosen-right");

            if (track) {
                var scrollPos = track.scrollLeft;
                var targetPos = track.scrollLeft;
                var isHovered = false;
                var isInteracting = false;
                var resumeTimer = null;
                var speed = 0.65; // ~39px per second (silky smooth readability)
                var stepAmount = 320; // 300px card + 20px gap

                track.addEventListener("mouseenter", function() { isHovered = true; });
                track.addEventListener("mouseleave", function() { isHovered = false; });
                track.addEventListener("touchstart", function() { isHovered = true; }, { passive: true });
                track.addEventListener("touchend", function() {
                    scrollPos = track.scrollLeft;
                    targetPos = track.scrollLeft;
                    isHovered = false;
                }, { passive: true });

                // Interactive Mouse Drag to Scroll
                var isDown = false;
                var startX = 0;
                var scrollStart = 0;

                track.addEventListener("mousedown", function(e) {
                    isDown = true;
                    isInteracting = true;
                    track.style.cursor = 'grabbing';
                    startX = e.pageX - track.offsetLeft;
                    scrollStart = track.scrollLeft;
                });

                window.addEventListener("mouseup", function() {
                    if (isDown) {
                        isDown = false;
                        track.style.cursor = 'grab';
                        scrollPos = track.scrollLeft;
                        targetPos = track.scrollLeft;
                        if (resumeTimer) clearTimeout(resumeTimer);
                        resumeTimer = setTimeout(function() { isInteracting = false; }, 1200);
                    }
                });

                track.addEventListener("mousemove", function(e) {
                    if (!isDown) return;
                    e.preventDefault();
                    var x = e.pageX - track.offsetLeft;
                    var walk = (x - startX) * 1.4;
                    track.scrollLeft = scrollStart - walk;
                    scrollPos = track.scrollLeft;
                    targetPos = scrollPos;
                });

                if (btnRight) {
                    btnRight.addEventListener("click", function(e) {
                        e.preventDefault();
                        isInteracting = true;
                        if (resumeTimer) clearTimeout(resumeTimer);
                        resumeTimer = setTimeout(function() { isInteracting = false; }, 1500);
                        targetPos += stepAmount;
                    });
                }

                if (btnLeft) {
                    btnLeft.addEventListener("click", function(e) {
                        e.preventDefault();
                        var half = track.scrollWidth / 2;
                        isInteracting = true;
                        if (resumeTimer) clearTimeout(resumeTimer);
                        resumeTimer = setTimeout(function() { isInteracting = false; }, 1500);
                        if (targetPos < stepAmount && half > 0) {
                            scrollPos += half;
                            targetPos += half;
                            track.scrollLeft = scrollPos;
                        }
                        targetPos -= stepAmount;
                    });
                }

                function animStep() {
                    var half = track.scrollWidth / 2;
                    var diff = targetPos - scrollPos;

                    if (Math.abs(diff) > 0.5) {
                        scrollPos += diff * 0.16;
                    } else {
                        scrollPos = targetPos;
                        if (!isHovered && !isInteracting && !isDown) {
                            scrollPos += speed;
                            targetPos = scrollPos;
                        }
                    }

                    if (half > 0) {
                        if (scrollPos >= half) {
                            scrollPos -= half;
                            targetPos -= half;
                        } else if (scrollPos < 0) {
                            scrollPos += half;
                            targetPos += half;
                        }
                    }

                    track.scrollLeft = scrollPos;
                    requestAnimationFrame(animStep);
                }

                requestAnimationFrame(animStep);
            }
        }

        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", initMotionEngine);
        } else {
            initMotionEngine();
        }
    })();
    </script>
    <?php
}
}
add_action('wp_footer', 'bk_enqueue_motion_engine_scripts', 99);

/**
 * Remove stray wpautop <br> and <p> for Elementor builder pages to preserve pixel-perfect layout
 */
add_action('wp', function() {
    if (is_singular('page')) {
        $post_id = get_the_ID();
        if (get_post_meta($post_id, '_elementor_edit_mode', true) === 'builder') {
            remove_filter('the_content', 'wpautop');
        }
    }
});

/**
 * Automatically purge Elementor element cache on post save to prevent stale widget rendering
 */
add_action('save_post', function($post_id) {
    delete_post_meta($post_id, '_elementor_element_cache');
    delete_post_meta($post_id, '_elementor_css');
});

/**
 * Global Suite Modal Viewer & Interactive Client Scripts
 * Placed in wp_footer to prevent WordPress KSES stripping and eliminate raw JS leakage.
 */
if (!function_exists('bk_render_suite_footer_assets')) {
function bk_render_suite_footer_assets() {
    ?>
    <!-- Global Drive Modal Viewer -->
    <div id="bkDriveModal" style="display:none;position:fixed;inset:0;z-index:99999;background:rgba(13,59,34,0.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;padding:16px;">
        <div style="background:#ffffff;border-radius:8px;max-width:900px;width:100%;max-height:92vh;display:flex;flex-direction:column;box-shadow:0 25px 50px -12px rgba(0,0,0,0.35);overflow:hidden;border:1px solid #D4E3D8;">
            <div style="padding:18px 24px;border-bottom:1px solid #E5E7EB;display:flex;align-items:center;justify-content:space-between;gap:12px;background:#FAF8F5;">
                <div style="flex:1;">
                    <span style="font-size:10px;font-weight:700;text-transform:uppercase;color:#0D3B22;letter-spacing:0.1em;display:block;">Pratinjau Dokumen Resmi</span>
                    <h3 id="bkModalTitle" style="font-family:'Fraunces',serif;font-size:17px;font-weight:700;color:#0D3B22;margin:2px 0 0;line-height:1.3;">Judul Dokumen</h3>
                </div>
                <div style="display:flex;align-items:center;gap:8px;">
                    <a id="bkModalExternalLink" href="#" target="_blank" rel="noopener noreferrer" style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:10px;background:#0D3B22;color:#ffffff;font-size:11.5px;font-weight:600;text-decoration:none;">
                        Buka di Tab Baru &nearr;
                    </a>
                    <button type="button" onclick="closeBkModal()" style="border:none;background:#E5E7EB;color:#374151;border-radius:10px;width:34px;height:34px;display:flex;align-items:center;justify-content:center;font-size:18px;cursor:pointer;font-weight:bold;">
                        &times;
                    </button>
                </div>
            </div>
            <div id="bkModalBody" style="flex:1;min-height:480px;background:#F9FAFB;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px;">
                <iframe id="bkModalIframe" src="" style="width:100%;height:520px;border:none;border-radius:12px;box-shadow:inset 0 2px 4px rgba(0,0,0,0.05);"></iframe>
            </div>
            <div style="padding:12px 24px;background:#FAF8F5;border-top:1px solid #E5E7EB;display:flex;align-items:center;justify-content:space-between;font-size:11.5px;color:#6B7280;">
                <span>Program Studi Bimbingan dan Konseling FIP UNM &bull; SPMI &amp; ABKIN</span>
                <span id="bkModalKet" style="color:#0D3B22;font-weight:600;"></span>
            </div>
        </div>
    </div>

    <script id="bk-suite-interactive-scripts">
    function openBkModal(title, link, ket) {
        var t = document.getElementById("bkModalTitle");
        var k = document.getElementById("bkModalKet");
        var ext = document.getElementById("bkModalExternalLink");
        var iframe = document.getElementById("bkModalIframe");
        var modal = document.getElementById("bkDriveModal");
        if (!modal) return;
        if (t) t.innerText = title || "";
        if (k) k.innerText = ket || "";
        if (ext) ext.href = link || "#";
        var previewUrl = link;
        if (link && link.indexOf("drive.google.com") !== -1) {
            previewUrl = link.replace(/\/view(\?.*)?$/, "/preview");
        }
        if (iframe) iframe.src = previewUrl;
        modal.style.display = "flex";
        document.body.style.overflow = "hidden";
    }

    function closeBkModal() {
        var modal = document.getElementById("bkDriveModal");
        if (modal) modal.style.display = "none";
        var iframe = document.getElementById("bkModalIframe");
        if (iframe) iframe.src = "";
        document.body.style.overflow = "";
    }

    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape") closeBkModal();
    });

    // Akademik Tabs & Alur
    function switchAkademikTab(tab) {
        var secAlur = document.getElementById("sectionAlur");
        var secTpl = document.getElementById("sectionTemplate");
        var btnAlur = document.getElementById("tabBtnAlur");
        var btnTpl = document.getElementById("tabBtnTemplate");
        if (!secAlur || !secTpl) return;
        if (tab === "alur") {
            secAlur.style.display = "block";
            secTpl.style.display = "none";
            if (btnAlur) { btnAlur.style.background = "#0D3B22"; btnAlur.style.color = "#ffffff"; }
            if (btnTpl) { btnTpl.style.background = "transparent"; btnTpl.style.color = "#4B5563"; }
        } else {
            secAlur.style.display = "none";
            secTpl.style.display = "block";
            if (btnTpl) { btnTpl.style.background = "#0D3B22"; btnTpl.style.color = "#ffffff"; }
            if (btnAlur) { btnAlur.style.background = "transparent"; btnAlur.style.color = "#4B5563"; }
        }
    }

    function selectAlur(key) {
        var panels = {
            "penelitian": { panel: "alurDetailPenelitian", btn: "btnAlurPenelitian" },
            "skripsi": { panel: "alurDetailSkripsi", btn: "btnAlurSkripsi" },
            "ukt": { panel: "alurDetailUkt", btn: "btnAlurUkt" }
        };
        for (var k in panels) {
            var p = document.getElementById(panels[k].panel);
            var b = document.getElementById(panels[k].btn);
            if (!p || !b) continue;
            if (k === key) {
                p.style.display = "block";
                b.style.background = "#0D3B22";
                b.style.color = "#ffffff";
                b.style.borderColor = "#0D3B22";
                var sp = b.querySelector("span");
                if (sp) sp.style.color = "#F5B82E";
            } else {
                p.style.display = "none";
                b.style.background = "#ffffff";
                b.style.color = "#1F2937";
                b.style.borderColor = "#D4E3D8";
                var sp = b.querySelector("span");
                if (sp) sp.style.color = "#6B7280";
            }
        }
    }

    // Template Filtering
    var currentTplFilter = "semua";
    function setTemplateFilter(cat) {
        currentTplFilter = cat;
        var pills = document.querySelectorAll(".tpl-filter-pill");
        pills.forEach(function(p) {
            p.style.background = "#F8FAFC";
            p.style.color = "#475569";
            p.style.border = "1px solid #E2E8F0";
        });
        if (window.event && window.event.target) {
            var btn = window.event.target.closest("button") || window.event.target;
            btn.style.background = "#0D3B22";
            btn.style.color = "#F5B82E";
            btn.style.border = "none";
        }
        filterTemplates();
    }

    function filterTemplates() {
        var input = document.getElementById("tplSearchInput");
        var q = input ? input.value.toLowerCase() : "";
        var cards = document.querySelectorAll(".tpl-card");
        cards.forEach(function(c) {
            var cat = c.getAttribute("data-cat");
            var txt = c.innerText.toLowerCase();
            var matchCat = (currentTplFilter === "semua" || cat === currentTplFilter);
            var matchQ = (q === "" || txt.indexOf(q) !== -1);
            c.style.display = (matchCat && matchQ) ? "flex" : "none";
        });
    }

    // Inventaris Lab Filtering
    var currentInvFilter = "semua";
    function setInvFilter(cat) {
        currentInvFilter = cat;
        var pills = document.querySelectorAll(".inv-filter-pill");
        pills.forEach(function(p) {
            p.style.background = "#F8FAFC";
            p.style.color = "#475569";
            p.style.border = "1px solid #E2E8F0";
        });
        if (window.event && window.event.target) {
            var btn = window.event.target.closest("button") || window.event.target;
            btn.style.background = "#0D3B22";
            btn.style.color = "#F5B82E";
            btn.style.border = "none";
        }
        filterInventaris();
    }

    function filterInventaris() {
        var input = document.getElementById("invSearchInput");
        var q = input ? input.value.toLowerCase() : "";
        var cards = document.querySelectorAll(".inv-card");
        cards.forEach(function(c) {
            var cat = c.getAttribute("data-cat");
            var txt = c.innerText.toLowerCase();
            var matchCat = (currentInvFilter === "semua" || cat === currentInvFilter);
            var matchQ = (q === "" || txt.indexOf(q) !== -1);
            c.style.display = (matchCat && matchQ) ? "flex" : "none";
        });
    }

    // Survey Stepper Wizard
    var currentStep = 1;
    var totalSteps = 5;
    var stepTitles = [
        "Langkah 1 dari 5: Identitas Responden",
        "Langkah 2 dari 5: Layanan Dosen & Tenaga Kependidikan",
        "Langkah 3 dari 5: Layanan Kemahasiswaan & Lab BK",
        "Langkah 4 dari 5: Tata Pamong & Tata Kelola",
        "Langkah 5 dari 5: Sarana Prasarana & Saran Perbaikan"
    ];

    function goToStep(step) {
        if (step < 1 || step > totalSteps) return;
        currentStep = step;

        for (var i = 1; i <= totalSteps; i++) {
            var panel = document.getElementById("surveyStep" + i);
            var btn = document.getElementById("btnStep" + i);
            if (panel) panel.style.display = (i === currentStep) ? "block" : "none";
            if (btn) {
                if (i === currentStep) {
                    btn.style.background = "#0D3B22";
                    btn.style.color = "#F5B82E";
                    btn.style.border = "none";
                } else {
                    btn.style.background = "#F9FAFB";
                    btn.style.color = "#6B7280";
                    btn.style.border = "1px solid #E5E7EB";
                }
            }
        }

        var counterEl = document.getElementById("stepCounterText");
        if (counterEl) counterEl.innerText = stepTitles[currentStep - 1];
        var pct = Math.round((currentStep / totalSteps) * 100);
        var pctEl = document.getElementById("stepPercentText");
        if (pctEl) pctEl.innerText = pct + "% Selesai";
        var bar = document.getElementById("surveyProgressBar");
        if (bar) bar.style.width = pct + "%";

        var prevBtn = document.getElementById("surveyPrevBtn");
        var nextBtn = document.getElementById("surveyNextBtn");
        var submitBtn = document.getElementById("surveySubmitBtn");

        if (prevBtn) prevBtn.style.display = (currentStep === 1) ? "none" : "block";
        if (nextBtn) nextBtn.style.display = (currentStep === totalSteps) ? "none" : "block";
        if (submitBtn) submitBtn.style.display = (currentStep === totalSteps) ? "block" : "none";

        var formCard = document.getElementById("surveyFormCard");
        if (formCard) {
            window.scrollTo({ top: formCard.offsetTop - 120, behavior: "smooth" });
        }
    }

    function nextSurveyStep() {
        goToStep(currentStep + 1);
    }

    function prevSurveyStep() {
        goToStep(currentStep - 1);
    }

    function submitSurvey() {
        var card = document.getElementById("surveyFormCard");
        var success = document.getElementById("surveySuccessCard");
        if (card) card.style.display = "none";
        if (success) {
            success.style.display = "block";
            window.scrollTo({ top: success.offsetTop - 120, behavior: "smooth" });
        }
    }

    // Global Unified Suite Event Handlers (Profil, Akademik, Kemahasiswaan, Layanan)
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Statistik Tabs (Akademik & Kemahasiswaan)
        var statBtns = document.querySelectorAll(".bk-stat-tab-btn");
        var statContents = document.querySelectorAll(".bk-stat-content");
        if (statBtns.length > 0) {
            statBtns.forEach(function(btn) {
                btn.addEventListener("click", function() {
                    statBtns.forEach(function(b) {
                        b.classList.remove("active");
                        b.style.background = "transparent";
                        b.style.color = "#4B5563";
                    });
                    this.classList.add("active");
                    this.style.background = "#0D3B22";
                    this.style.color = "#ffffff";
                    var targetTab = this.getAttribute("data-tab");
                    statContents.forEach(function(c) { c.style.display = "none"; });
                    var targetEl = document.getElementById("bk-stat-content-" + targetTab);
                    if (targetEl) targetEl.style.display = "block";
                });
            });
        }

        // 2. Kurikulum Semester Tabs (Akademik)
        var semBtns = document.querySelectorAll(".bk-sem-tab-btn");
        var semContents = document.querySelectorAll(".bk-sem-content");
        if (semBtns.length > 0) {
            semBtns.forEach(function(btn) {
                btn.addEventListener("click", function() {
                    semBtns.forEach(function(b) {
                        b.classList.remove("active");
                        b.style.background = "transparent";
                        b.style.color = "#4B5563";
                    });
                    this.classList.add("active");
                    this.style.background = "#0D3B22";
                    this.style.color = "#F5B82E";
                    var sem = this.getAttribute("data-sem");
                    semContents.forEach(function(c) { c.style.display = "none"; });
                    var targetSem = document.getElementById("bk-sem-content-" + sem);
                    if (targetSem) targetSem.style.display = "block";
                });
            });
        }

        // 3. Sejarah Era Tabs (Profil Sejarah)
        var eraTabs = document.querySelectorAll("#bk-era-tabs .bk-era-btn");
        var pimpinanCards = document.querySelectorAll("#bk-pimpinan-grid .bk-pimpinan-card");
        if (eraTabs.length > 0) {
            eraTabs.forEach(function(tab) {
                tab.addEventListener("click", function() {
                    eraTabs.forEach(function(t) {
                        t.style.background = "transparent";
                        t.style.color = "#4B5563";
                        t.classList.remove("active");
                    });
                    this.style.background = "#0D3B22";
                    this.style.color = "#F5B82E";
                    this.classList.add("active");
                    var selected = this.getAttribute("data-era");
                    pimpinanCards.forEach(function(card) {
                        if (selected === "semua" || card.getAttribute("data-era") === selected) {
                            card.style.display = "flex";
                        } else {
                            card.style.display = "none";
                        }
                    });
                });
            });
        }

        // 4. Dosen Filter & Search (Profil Dosen)
        var dsnInput = document.getElementById("bk-dosen-search-input");
        var dsnCountInfo = document.getElementById("bk-dosen-count-info");
        var dsnChips = document.querySelectorAll("#bk-chip-filters .bk-chip-btn");
        var dsnCards = document.querySelectorAll("#bk-dosen-grid .bk-dosen-card-item");
        var dsnActiveTag = "semua";

        function filterDosen() {
            var q = (dsnInput ? dsnInput.value : "").toLowerCase().trim();
            var visibleCount = 0;
            dsnCards.forEach(function(card) {
                var text = (card.getAttribute("data-text") || "").toLowerCase();
                var matchQuery = !q || text.indexOf(q) !== -1;
                var matchTag = (dsnActiveTag === "semua") || text.indexOf(dsnActiveTag.toLowerCase()) !== -1;
                if (matchQuery && matchTag) {
                    card.style.display = "flex";
                    visibleCount++;
                } else {
                    card.style.display = "none";
                }
            });
            if (dsnCountInfo) {
                if (q || dsnActiveTag !== "semua") {
                    dsnCountInfo.innerHTML = "Ditemukan <strong style='color:#F5B82E;'>" + visibleCount + "</strong> dosen yang sesuai filter";
                } else {
                    dsnCountInfo.innerHTML = "Menampilkan seluruh " + dsnCards.length + " dosen dan tenaga pengajar Jurusan PPB";
                }
            }
        }
        if (dsnInput) dsnInput.addEventListener("input", filterDosen);
        if (dsnChips.length > 0) {
            dsnChips.forEach(function(chip) {
                chip.addEventListener("click", function() {
                    dsnChips.forEach(function(c) {
                        c.style.background = "#FAF8F5";
                        c.style.color = "#4B5563";
                        c.classList.remove("active");
                    });
                    this.style.background = "#0D3B22";
                    this.style.color = "#F5B82E";
                    this.classList.add("active");
                    dsnActiveTag = this.getAttribute("data-tag") || "semua";
                    filterDosen();
                });
            });
        }

        // 5. Dokumen Mutu Filter & Search (Profil Dokumen)
        var dokInput = document.getElementById("bk-dok-search-input");
        var dokTabs = document.querySelectorAll("#bk-dok-tabs .bk-dok-btn");
        var dokCards = document.querySelectorAll("#bk-dok-grid .bk-dok-card-item");
        var dokActiveKat = "semua";

        function filterDokumen() {
            var q = (dokInput ? dokInput.value : "").toLowerCase().trim();
            dokCards.forEach(function(card) {
                var text = (card.getAttribute("data-search") || "").toLowerCase();
                var kat = (card.getAttribute("data-kat") || "").toLowerCase();
                var matchQuery = !q || text.indexOf(q) !== -1;
                var matchKat = (dokActiveKat === "semua") || (kat === dokActiveKat.toLowerCase());
                card.style.display = (matchQuery && matchKat) ? "flex" : "none";
            });
        }
        if (dokInput) dokInput.addEventListener("input", filterDokumen);
        if (dokTabs.length > 0) {
            dokTabs.forEach(function(tab) {
                tab.addEventListener("click", function() {
                    dokTabs.forEach(function(t) {
                        t.style.background = "#FAF8F5";
                        t.style.color = "#4B5563";
                        t.classList.remove("active");
                    });
                    this.style.background = "#0D3B22";
                    this.style.color = "#F5B82E";
                    this.classList.add("active");
                    dokActiveKat = this.getAttribute("data-kat") || "semua";
                    filterDokumen();
                });
            });
        }
    });
    </script>
    <?php
}
}
add_action('wp_footer', 'bk_render_suite_footer_assets', 100);

