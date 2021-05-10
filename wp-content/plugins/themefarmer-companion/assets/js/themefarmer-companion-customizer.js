(function($) {

    // home slider
    wp.customize('themefarmer_home_slider', function(value) {
        var oldObj;
        value.bind(function(to) {
            var repeater = to;
            console.log(repeater);
            var focusIndex = 0;
            if (typeof(oldObj) === 'undefined') {
                oldObj = repeater;
            }

            var html = '';
            $.each(repeater, function(key, item) {

                if (JSON.stringify(oldObj[key]) !== JSON.stringify(item)) {
                    focusIndex = key;
                    oldObj = repeater;
                }

                html += '<div class="owl-slide">' +
                    '<img src="' + item.image + '" class="img-responsive img-slide">' +
                    '<div class="overlay"></div>' +
                    '<div class="carousel-caption">' +
                    '<h2 class="slider-heading animation"> ' + item.heading + ' </h2>' +
                    '<div class="slider-desc animation">' + item.description + '</div>' +
                    '<a href="' + item.button1_url + '" class="btn banner-link"> ' + item.button1_text + ' </a>' +
                    '<a href="' + item.button2_url + '" class="btn banner-link slide-bt-2"> ' + item.button2_text + ' </a>' +
                    '</div>' +
                    '</div>';
            });
            window.home_carousel.trigger('replace.owl.carousel', html);
            window.home_carousel.trigger('refresh.owl.carousel')
            window.home_carousel.trigger('to.owl.carousel', [focusIndex, 0]);
            setTimeout(function() {
                window.home_carousel.find('.carousel-caption').removeClass('customize-partial-refreshing');
            }, 100);
        });
    });

     wp.customize('themefarmer_home_services', function(value) {
        value.bind(function(to) {
            var repeater = to;
            var html = '';
            $.each(repeater, function(key, item) {

                var button = '';
                if (item.button1_url) {
                    button = '<a class="btn btn-read-more" href="' + item.button_url + '">' + item.button_text + '</a>';
                }

                html += '<div class="col-md-4 col-sm-6 col-xs-6 service-item" style="color:' + item.color + '">' +
                    '<div class="service-item-inner">' +
                    '<div class="service-inner-info">' +
                    '<div class="service-icon">' +
                    '<i class="fa ' + item.icon + '"></i>' +
                    '</div>' +
                    '<div class="service-info">' +
                    '<h3 class="sub-section-title service-title">' + item.heading + '</h3>' +
                    '<p class="sub-section-description service-description">' + item.description + '</p>' +
                    button +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            });
            $('.services-details').html(html);
            setTimeout(function() {
                $('.services-details').find('.customize-partial-refreshing').removeClass('customize-partial-refreshing');
            }, 100);
        });
    });


    wp.customize('themefarmer_home_features', function(value) {
        value.bind(function(to) {
            var repeater = to;
            var html = '';
            $.each(repeater, function(key, item) {

                html += '<div class="col-md-3 col-sm-6 col-xs-6 feature-item">' +
                    '<div class="feature-item-inner">' +
                    '<div class="feature-inner-info">' +
                    '<div class="feature-icon">' +
                    '<i class="fa ' + item.icon + '"></i>' +
                    '</div>' +
                    '<div class="feature-info">' +
                    '<h3 class="feature-title">' + item.heading + '</h3>' +
                    '<p class="feature-desc">' + item.description + '</p>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            });
            $('.features-details').html(html);
            setTimeout(function() {
                $('.features-details').find('.customize-partial-refreshing').removeClass('customize-partial-refreshing');
            }, 100);
        });
    });

    // testi slider
    wp.customize('themefarmer_home_testimonials', function(value) {
        var oldObj;
        value.bind(function(to) {

            var repeater = to;
            var focusIndex = 0;
            if (typeof(oldObj) === 'undefined') {
                oldObj = repeater;
            }

            var html = '';
            $.each(repeater, function(key, item) {

                if (JSON.stringify(oldObj[key]) !== JSON.stringify(item)) {
                    focusIndex = key;
                    oldObj = repeater;
                }

                html += '<div class="testimonial-item">' +
                            '<div class="testimonial-item-inner">' +
                                '<div class="testimonial-img">' +
                                    '<img  class="img-responsive" src="' + item.image + '">' +
                                    '<h2 class="testimonial-name">' + item.title + '</h2>' +
                                '</div>' +
                                '<div class="testimonial-info">' +
                                    '<h6 class="testimonial-designation">' + item.subtitle + '</h6>' +
                                    '<p class="testimonial-description">' + item.description + '</p>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            });
            window.testimonial_carousel.trigger('replace.owl.carousel', html);
            window.testimonial_carousel.trigger('refresh.owl.carousel')
            window.testimonial_carousel.trigger('to.owl.carousel', [focusIndex, 0]);
        });
    });

    wp.customize('themefarmer_home_brands', function(value) {
        var oldObj;
        value.bind(function(to) {

            var repeater = to;
            var focusIndex = 0;
            if (typeof(oldObj) === 'undefined') {
                oldObj = repeater;
            }

            var html = '';
            $.each(repeater, function(key, item) {

                if (JSON.stringify(oldObj[key]) !== JSON.stringify(item)) {
                    focusIndex = key;
                    oldObj = repeater;
                }
                if (item.brand_link) {
                    html += '<div class="brand-item">' +
                        '<div class="brand-item-inner">' +
                        '<a href="' + item.brand_link + '">' +
                        '<img class="img-responsive" src="' + item.image + '">' +
                        '</a>' +
                        '</div>' +
                        '</div>';
                } else {
                    html += '<div class="brand-item">' +
                        '<div class="brand-item-inner">' +
                        '<img class="img-responsive" src="' + item.image + '">' +
                        '</div>' +
                        '</div>';
                }
            });
            if(true){
                $('.brands-details').html(html);
            }else{
                window.brand_carousel.trigger('replace.owl.carousel', html);
                window.brand_carousel.trigger('refresh.owl.carousel')
                window.brand_carousel.trigger('to.owl.carousel', [focusIndex, 0]);
            }
        });
    });

    wp.customize('themefarmer_home_team', function(value) {
        var oldObj;
        value.bind(function(to) {

            var repeater = to;
            var focusIndex = 0;
            if (typeof(oldObj) === 'undefined') {
                oldObj = repeater;
            }

            var html = '';
            $.each(repeater, function(key, item) {

                if (JSON.stringify(oldObj[key]) !== JSON.stringify(item)) {
                    focusIndex = key;
                    oldObj = repeater;
                }

                var socials_html = '';
                if (item.socials) {
                    $.each(item.socials, function(ind11, vall1) {
                        socials_html += '<li><a href="' + vall1.link + '"> <i class="fa ' + vall1.icon + '"></i> </a></li>';
                    });
                }
                var title = '';

                if (item.button_url) {
                    title = '<a href="' + item.button_url + '">' +
                        '<h3 class="sub-section-title  member-title">' + item.name + '</h3>' +
                        '</a>';
                } else {
                    title = '<h3 class="sub-section-title  member-title">' + item.name + '</h3>';
                }

                html += '<div class="col-md-3 col-sm-6 col-xs-6 member-item">' +
                    '<div class="meamber-item-inner">' +
                    '<div class="meamber-image">' +
                    '<img src="' + item.image + '" class="img-responsive">' +
                    '</div>' +
                    '<div class="meamber-info">' +
                    title +
                    '<h6 class="member-designation">' + item.designation + '</h6>' +
                    '<p class="member-description">' + item.description + '</p>' +
                    '<div class="member-icons">' +
                    '<ul>' + socials_html + '</ul>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            });
            if (true) {
                $('.team-details').html(html);
            } else {
                window.team_carousel.trigger('replace.owl.carousel', html);
                window.team_carousel.trigger('refresh.owl.carousel')
                window.team_carousel.trigger('to.owl.carousel', [focusIndex, 0]);
            }
        });
    });

    wp.customize('themefarmer_home_about_image', function(value) {
        value.bind(function(to) {
            if ($('.about-item-2 .about-item-inner img').length) {
                $('.about-item-2 .about-item-inner img').attr('src', to);
            } else {
                $('.about-item-2 .about-item-inner').html('<img src="' + to + '">');
            }
        });
    });

    wp.customize('themefarmer_home_layout', function(value) {
        value.bind(function(to) {
            var items = to;
            var oldItem;
            $.each(items, function(index, item) {
                if (index >= 0) {
                    $('.section-' + item).insertAfter('.section-' + oldItem);
                }
                oldItem = item;
            });
        });
    });



    var sections = [{
            'heading': {
                'id': 'themefarmer_home_services_heading',
                'selector': '.section-services .section-title',
            },
            'description': {
                'id': 'themefarmer_home_services_desc',
                'selector': '.section-services .section-description',
            },
        },
        {
            'heading': {
                'id': 'themefarmer_home_team_heading',
                'selector': '.section-team .section-title',
            },
            'description': {
                'id': 'themefarmer_home_team_desc',
                'selector': '.section-team .section-description',
            },
        },
        {
            'heading': {
                'id': 'themefarmer_home_subscribe_heading',
                'selector': '.section-subscribe .section-title',
            },
            'description': {
                'id': 'themefarmer_home_subscribe_desc',
                'selector': '.section-subscribe .section-description',
            },
        },
        {
            'heading': {
                'id': 'themefarmer_home_contact_heading',
                'selector': '.section-contact .section-title',
            },
            'description': {
                'id': 'themefarmer_home_contact_desc',
                'selector': '.section-contact .section-description',
            },
        },
        {
            'heading': {
                'id': 'themefarmer_home_testimonials_heading',
                'selector': '.section-testimonials .section-title',
            },
            'description': {
                'id': 'themefarmer_home_testimonials_desc',
                'selector': '.section-testimonials .section-description',
            },
        },
        {
            'heading': {
                'id': 'themefarmer_home_brands_heading',
                'selector': '.section-brands .section-title',
            },
            'description': {
                'id': 'themefarmer_home_brands_desc',
                'selector': '.section-brands .section-description',
            },
        },
        {
            'heading': {
                'id': 'themefarmer_home_about_heading',
                'selector': '.section-about .section-title',
            },
            'description': {
                'id': 'themefarmer_home_about_desc',
                'selector': '.section-about .section-description',
            },
        },
        {
            'heading': {
                'id': 'themefarmer_home_product_tabs_heading',
                'selector': '.section-product-tabs .section-title',
            },
            'description': {
                'id': 'themefarmer_home_product_tabs_desc',
                'selector': '.section-product-tabs .section-description',
            },
        },
        
    ];

    $.each(sections, function(index, item) {
        $.each(item, function(i, control) {
            wp.customize(control.id, function(value) {
                value.bind(function(to) {
                    setTimeout(function() {
                        $(control.selector).removeClass('customize-partial-refreshing');
                    },100);
                    if($(control.selector)[0].lastChild.nodeValue){
                        $(control.selector)[0].lastChild.nodeValue = to;
                        
                    }else{
                        $(control.selector+' .customize-partial-edit-shortcut').after(to);
                    }
                });
            });
        });
    });

    wp.customize('themefarmer_body_font_size', function(value) {
        value.bind(function(to) {
            if (isNaN(to)) {
                var body_fs = JSON.parse(to);
                var desk_fs = parseFloat(body_fs.desktop);
                var tabl_fs = parseFloat(body_fs.tablat);
                var mobi_fs = parseFloat(body_fs.mobile);
            } else {
                var desk_fs = parseFloat(to);
            }
            var size = parseFloat(desk_fs);
            var body = size + 4;
            $('body').css('font-size', body + 'px');
        });
    });

    wp.customize('themefarmer_body_font_family', function(value) {
        value.bind(function(font_family) {
            var google_fonts = ['ABeeZee', 'Abel', 'Abhaya Libre', 'Abril Fatface', 'Aclonica', 'Acme', 'Actor', 'Adamina', 'Advent Pro', 'Aguafina Script', 'Akronim', 'Aladin', 'Aldrich', 'Alef', 'Alegreya', 'Alegreya SC', 'Alegreya Sans', 'Alegreya Sans SC', 'Alex Brush', 'Alfa Slab One', 'Alice', 'Alike', 'Alike Angular', 'Allan', 'Allerta', 'Allerta Stencil', 'Allura', 'Almendra', 'Almendra Display', 'Almendra SC', 'Amarante', 'Amaranth', 'Amatic SC', 'Amethysta', 'Amiko', 'Amiri', 'Amita', 'Anaheim', 'Andada', 'Andika', 'Angkor', 'Annie Use Your Telescope', 'Anonymous Pro', 'Antic', 'Antic Didone', 'Antic Slab', 'Anton', 'Arapey', 'Arbutus', 'Arbutus Slab', 'Architects Daughter', 'Archivo', 'Archivo Black', 'Archivo Narrow', 'Aref Ruqaa', 'Arima Madurai', 'Arimo', 'Arizonia', 'Armata', 'Arsenal', 'Artifika', 'Arvo', 'Arya', 'Asap', 'Asap Condensed', 'Asar', 'Asset', 'Assistant', 'Astloch', 'Asul', 'Athiti', 'Atma', 'Atomic Age', 'Aubrey', 'Audiowide', 'Autour One', 'Average', 'Average Sans', 'Averia Gruesa Libre', 'Averia Libre', 'Averia Sans Libre', 'Averia Serif Libre', 'Bad Script', 'Bahiana', 'Baloo', 'Baloo Bhai', 'Baloo Bhaijaan', 'Baloo Bhaina', 'Baloo Chettan', 'Baloo Da', 'Baloo Paaji', 'Baloo Tamma', 'Baloo Tammudu', 'Baloo Thambi', 'Balthazar', 'Bangers', 'Barlow', 'Barlow Condensed', 'Barlow Semi Condensed', 'Barrio', 'Basic', 'Battambang', 'Baumans', 'Bayon', 'Belgrano', 'Bellefair', 'Belleza', 'BenchNine', 'Bentham', 'Berkshire Swash', 'Bevan', 'Bigelow Rules', 'Bigshot One', 'Bilbo', 'Bilbo Swash Caps', 'BioRhyme', 'BioRhyme Expanded', 'Biryani', 'Bitter', 'Black Ops One', 'Bokor', 'Bonbon', 'Boogaloo', 'Bowlby One', 'Bowlby One SC', 'Brawler', 'Bree Serif', 'Bubblegum Sans', 'Bubbler One', 'Buda', 'Buenard', 'Bungee', 'Bungee Hairline', 'Bungee Inline', 'Bungee Outline', 'Bungee Shade', 'Butcherman', 'Butterfly Kids', 'Cabin', 'Cabin Condensed', 'Cabin Sketch', 'Caesar Dressing', 'Cagliostro', 'Cairo', 'Calligraffitti', 'Cambay', 'Cambo', 'Candal', 'Cantarell', 'Cantata One', 'Cantora One', 'Capriola', 'Cardo', 'Carme', 'Carrois Gothic', 'Carrois Gothic SC', 'Carter One', 'Catamaran', 'Caudex', 'Caveat', 'Caveat Brush', 'Cedarville Cursive', 'Ceviche One', 'Changa', 'Changa One', 'Chango', 'Chathura', 'Chau Philomene One', 'Chela One', 'Chelsea Market', 'Chenla', 'Cherry Cream Soda', 'Cherry Swash', 'Chewy', 'Chicle', 'Chivo', 'Chonburi', 'Cinzel', 'Cinzel Decorative', 'Clicker Script', 'Coda', 'Coda Caption', 'Codystar', 'Coiny', 'Combo', 'Comfortaa', 'Coming Soon', 'Concert One', 'Condiment', 'Content', 'Contrail One', 'Convergence', 'Cookie', 'Copse', 'Corben', 'Cormorant', 'Cormorant Garamond', 'Cormorant Infant', 'Cormorant SC', 'Cormorant Unicase', 'Cormorant Upright', 'Courgette', 'Cousine', 'Coustard', 'Covered By Your Grace', 'Crafty Girls', 'Creepster', 'Crete Round', 'Crimson Text', 'Croissant One', 'Crushed', 'Cuprum', 'Cutive', 'Cutive Mono', 'Damion', 'Dancing Script', 'Dangrek', 'David Libre', 'Dawning of a New Day', 'Days One', 'Dekko', 'Delius', 'Delius Swash Caps', 'Delius Unicase', 'Della Respira', 'Denk One', 'Devonshire', 'Dhurjati', 'Didact Gothic', 'Diplomata', 'Diplomata SC', 'Domine', 'Donegal One', 'Doppio One', 'Dorsa', 'Dosis', 'Dr Sugiyama', 'Duru Sans', 'Dynalight', 'EB Garamond', 'Eagle Lake', 'Eater', 'Economica', 'Eczar', 'El Messiri', 'Electrolize', 'Elsie', 'Elsie Swash Caps', 'Emblema One', 'Emilys Candy', 'Encode Sans', 'Encode Sans Condensed', 'Encode Sans Expanded', 'Encode Sans Semi Condensed', 'Encode Sans Semi Expanded', 'Engagement', 'Englebert', 'Enriqueta', 'Erica One', 'Esteban', 'Euphoria Script', 'Ewert', 'Exo', 'Exo 2', 'Expletus Sans', 'Fanwood Text', 'Farsan', 'Fascinate', 'Fascinate Inline', 'Faster One', 'Fasthand', 'Fauna One', 'Faustina', 'Federant', 'Federo', 'Felipa', 'Fenix', 'Finger Paint', 'Fira Mono', 'Fira Sans', 'Fira Sans Condensed', 'Fira Sans Extra Condensed', 'Fjalla One', 'Fjord One', 'Flamenco', 'Flavors', 'Fondamento', 'Fontdiner Swanky', 'Forum', 'Francois One', 'Frank Ruhl Libre', 'Freckle Face', 'Fredericka the Great', 'Fredoka One', 'Freehand', 'Fresca', 'Frijole', 'Fruktur', 'Fugaz One', 'GFS Didot', 'GFS Neohellenic', 'Gabriela', 'Gafata', 'Galada', 'Galdeano', 'Galindo', 'Gentium Basic', 'Gentium Book Basic', 'Geo', 'Geostar', 'Geostar Fill', 'Germania One', 'Gidugu', 'Gilda Display', 'Give You Glory', 'Glass Antiqua', 'Glegoo', 'Gloria Hallelujah', 'Goblin One', 'Gochi Hand', 'Gorditas', 'Goudy Bookletter 1911', 'Graduate', 'Grand Hotel', 'Gravitas One', 'Great Vibes', 'Griffy', 'Gruppo', 'Gudea', 'Gurajada', 'Habibi', 'Halant', 'Hammersmith One', 'Hanalei', 'Hanalei Fill', 'Handlee', 'Hanuman', 'Happy Monkey', 'Harmattan', 'Headland One', 'Heebo', 'Henny Penny', 'Herr Von Muellerhoff', 'Hind', 'Hind Guntur', 'Hind Madurai', 'Hind Siliguri', 'Hind Vadodara', 'Holtwood One SC', 'Homemade Apple', 'Homenaje', 'IBM Plex Mono', 'IBM Plex Sans', 'IBM Plex Sans Condensed', 'IBM Plex Serif', 'IM Fell DW Pica', 'IM Fell DW Pica SC', 'IM Fell Double Pica', 'IM Fell Double Pica SC', 'IM Fell English', 'IM Fell English SC', 'IM Fell French Canon', 'IM Fell French Canon SC', 'IM Fell Great Primer', 'IM Fell Great Primer SC', 'Iceberg', 'Iceland', 'Imprima', 'Inconsolata', 'Inder', 'Indie Flower', 'Inika', 'Inknut Antiqua', 'Irish Grover', 'Istok Web', 'Italiana', 'Italianno', 'Itim', 'Jacques Francois', 'Jacques Francois Shadow', 'Jaldi', 'Jim Nightshade', 'Jockey One', 'Jolly Lodger', 'Jomhuria', 'Josefin Sans', 'Josefin Slab', 'Joti One', 'Judson', 'Julee', 'Julius Sans One', 'Junge', 'Jura', 'Just Another Hand', 'Just Me Again Down Here', 'Kadwa', 'Kalam', 'Kameron', 'Kanit', 'Kantumruy', 'Karla', 'Karma', 'Katibeh', 'Kaushan Script', 'Kavivanar', 'Kavoon', 'Kdam Thmor', 'Keania One', 'Kelly Slab', 'Kenia', 'Khand', 'Khmer', 'Khula', 'Kite One', 'Knewave', 'Kotta One', 'Koulen', 'Kranky', 'Kreon', 'Kristi', 'Krona One', 'Kumar One', 'Kumar One Outline', 'Kurale', 'La Belle Aurore', 'Laila', 'Lakki Reddy', 'Lalezar', 'Lancelot', 'Lateef', 'Lato', 'League Script', 'Leckerli One', 'Ledger', 'Lekton', 'Lemon', 'Lemonada', 'Libre Barcode 128', 'Libre Barcode 128 Text', 'Libre Barcode 39', 'Libre Barcode 39 Extended', 'Libre Barcode 39 Extended Text', 'Libre Barcode 39 Text', 'Libre Baskerville', 'Libre Franklin', 'Life Savers', 'Lilita One', 'Lily Script One', 'Limelight', 'Linden Hill', 'Lobster', 'Lobster Two', 'Londrina Outline', 'Londrina Shadow', 'Londrina Sketch', 'Londrina Solid', 'Lora', 'Love Ya Like A Sister', 'Loved by the King', 'Lovers Quarrel', 'Luckiest Guy', 'Lusitana', 'Lustria', 'Macondo', 'Macondo Swash Caps', 'Mada', 'Magra', 'Maiden Orange', 'Maitree', 'Mako', 'Mallanna', 'Mandali', 'Manuale', 'Marcellus', 'Marcellus SC', 'Marck Script', 'Margarine', 'Marko One', 'Marmelad', 'Martel', 'Martel Sans', 'Marvel', 'Mate', 'Mate SC', 'Maven Pro', 'McLaren', 'Meddon', 'MedievalSharp', 'Medula One', 'Meera Inimai', 'Megrim', 'Meie Script', 'Merienda', 'Merienda One', 'Merriweather', 'Merriweather Sans', 'Metal', 'Metal Mania', 'Metamorphous', 'Metrophobic', 'Michroma', 'Milonga', 'Miltonian', 'Miltonian Tattoo', 'Mina', 'Miniver', 'Miriam Libre', 'Mirza', 'Miss Fajardose', 'Mitr', 'Modak', 'Modern Antiqua', 'Mogra', 'Molengo', 'Molle', 'Monda', 'Monofett', 'Monoton', 'Monsieur La Doulaise', 'Montaga', 'Montez', 'Montserrat', 'Montserrat Alternates', 'Montserrat Subrayada', 'Moul', 'Moulpali', 'Mountains of Christmas', 'Mouse Memoirs', 'Mr Bedfort', 'Mr Dafoe', 'Mr De Haviland', 'Mrs Saint Delafield', 'Mrs Sheppards', 'Mukta', 'Mukta Mahee', 'Mukta Malar', 'Mukta Vaani', 'Muli', 'Mystery Quest', 'NTR', 'Nanum Brush Script', 'Nanum Gothic', 'Nanum Gothic Coding', 'Nanum Myeongjo', 'Nanum Pen Script', 'Neucha', 'Neuton', 'New Rocker', 'News Cycle', 'Niconne', 'Nixie One', 'Nobile', 'Nokora', 'Norican', 'Nosifer', 'Nothing You Could Do', 'Noticia Text', 'Noto Sans', 'Noto Serif', 'Nova Cut', 'Nova Flat', 'Nova Mono', 'Nova Oval', 'Nova Round', 'Nova Script', 'Nova Slim', 'Nova Square', 'Numans', 'Nunito', 'Nunito Sans', 'Odor Mean Chey', 'Offside', 'Old Standard TT', 'Oldenburg', 'Oleo Script', 'Oleo Script Swash Caps', 'Open Sans', 'Open Sans Condensed', 'Oranienbaum', 'Orbitron', 'Oregano', 'Orienta', 'Original Surfer', 'Oswald', 'Over the Rainbow', 'Overlock', 'Overlock SC', 'Overpass', 'Overpass Mono', 'Ovo', 'Oxygen', 'Oxygen Mono', 'PT Mono', 'PT Sans', 'PT Sans Caption', 'PT Sans Narrow', 'PT Serif', 'PT Serif Caption', 'Pacifico', 'Padauk', 'Palanquin', 'Palanquin Dark', 'Pangolin', 'Paprika', 'Parisienne', 'Passero One', 'Passion One', 'Pathway Gothic One', 'Patrick Hand', 'Patrick Hand SC', 'Pattaya', 'Patua One', 'Pavanam', 'Paytone One', 'Peddana', 'Peralta', 'Permanent Marker', 'Petit Formal Script', 'Petrona', 'Philosopher', 'Piedra', 'Pinyon Script', 'Pirata One', 'Plaster', 'Play', 'Playball', 'Playfair Display', 'Playfair Display SC', 'Podkova', 'Poiret One', 'Poller One', 'Poly', 'Pompiere', 'Pontano Sans', 'Poppins', 'Port Lligat Sans', 'Port Lligat Slab', 'Pragati Narrow', 'Prata', 'Preahvihear', 'Press Start 2P', 'Pridi', 'Princess Sofia', 'Prociono', 'Prompt', 'Prosto One', 'Proza Libre', 'Puritan', 'Purple Purse', 'Quando', 'Quantico', 'Quattrocento', 'Quattrocento Sans', 'Questrial', 'Quicksand', 'Quintessential', 'Qwigley', 'Racing Sans One', 'Radley', 'Rajdhani', 'Rakkas', 'Raleway', 'Raleway Dots', 'Ramabhadra', 'Ramaraja', 'Rambla', 'Rammetto One', 'Ranchers', 'Rancho', 'Ranga', 'Rasa', 'Rationale', 'Ravi Prakash', 'Redressed', 'Reem Kufi', 'Reenie Beanie', 'Revalia', 'Rhodium Libre', 'Ribeye', 'Ribeye Marrow', 'Righteous', 'Risque', 'Roboto', 'Roboto Condensed', 'Roboto Mono', 'Roboto Slab', 'Rochester', 'Rock Salt', 'Rokkitt', 'Romanesco', 'Ropa Sans', 'Rosario', 'Rosarivo', 'Rouge Script', 'Rozha One', 'Rubik', 'Rubik Mono One', 'Ruda', 'Rufina', 'Ruge Boogie', 'Ruluko', 'Rum Raisin', 'Ruslan Display', 'Russo One', 'Ruthie', 'Rye', 'Sacramento', 'Sahitya', 'Sail', 'Saira', 'Saira Condensed', 'Saira Extra Condensed', 'Saira Semi Condensed', 'Salsa', 'Sanchez', 'Sancreek', 'Sansita', 'Sarala', 'Sarina', 'Sarpanch', 'Satisfy', 'Scada', 'Scheherazade', 'Schoolbell', 'Scope One', 'Seaweed Script', 'Secular One', 'Sedgwick Ave', 'Sedgwick Ave Display', 'Sevillana', 'Seymour One', 'Shadows Into Light', 'Shadows Into Light Two', 'Shanti', 'Share', 'Share Tech', 'Share Tech Mono', 'Shojumaru', 'Short Stack', 'Shrikhand', 'Siemreap', 'Sigmar One', 'Signika', 'Signika Negative', 'Simonetta', 'Sintony', 'Sirin Stencil', 'Six Caps', 'Skranji', 'Slabo 13px', 'Slabo 27px', 'Slackey', 'Smokum', 'Smythe', 'Sniglet', 'Snippet', 'Snowburst One', 'Sofadi One', 'Sofia', 'Sonsie One', 'Sorts Mill Goudy', 'Source Code Pro', 'Source Sans Pro', 'Source Serif Pro', 'Space Mono', 'Special Elite', 'Spectral', 'Spectral SC', 'Spicy Rice', 'Spinnaker', 'Spirax', 'Squada One', 'Sree Krushnadevaraya', 'Sriracha', 'Stalemate', 'Stalinist One', 'Stardos Stencil', 'Stint Ultra Condensed', 'Stint Ultra Expanded', 'Stoke', 'Strait', 'Sue Ellen Francisco', 'Suez One', 'Sumana', 'Sunshiney', 'Supermercado One', 'Sura', 'Suranna', 'Suravaram', 'Suwannaphum', 'Swanky and Moo Moo', 'Syncopate', 'Tangerine', 'Taprom', 'Tauri', 'Taviraj', 'Teko', 'Telex', 'Tenali Ramakrishna', 'Tenor Sans', 'Text Me One', 'The Girl Next Door', 'Tienne', 'Tillana', 'Timmana', 'Tinos', 'Titan One', 'Titillium Web', 'Trade Winds', 'Trirong', 'Trocchi', 'Trochut', 'Trykker', 'Tulpen One', 'Ubuntu', 'Ubuntu Condensed', 'Ubuntu Mono', 'Ultra', 'Uncial Antiqua', 'Underdog', 'Unica One', 'UnifrakturCook', 'UnifrakturMaguntia', 'Unkempt', 'Unlock', 'Unna', 'VT323', 'Vampiro One', 'Varela', 'Varela Round', 'Vast Shadow', 'Vesper Libre', 'Vibur', 'Vidaloka', 'Viga', 'Voces', 'Volkhov', 'Vollkorn', 'Vollkorn SC', 'Voltaire', 'Waiting for the Sunrise', 'Wallpoet', 'Walter Turncoat', 'Warnes', 'Wellfleet', 'Wendy One', 'Wire One', 'Work Sans', 'Yanone Kaffeesatz', 'Yantramanav', 'Yatra One', 'Yellowtail', 'Yeseva One', 'Yesteryear', 'Yrsa', 'Zeyada', 'Zilla Slab', 'Zilla Slab Highlight'];
            if (google_fonts.indexOf(font_family) !== -1) {
                if($('#themefarmer-fonts-style-css').length){
                    $('#themefarmer-fonts-style-css').attr('href', insertParam2('family', font_family));
                }
                else{
                    $('head').append('<link id="themefarmer-google-font-style-css" rel="stylesheet" type="text/css" href="'+insertParam2('family', font_family)+'">');
                }
                $('body').css('font-family', "'"+font_family+"', sans-serif");
            } else {
                $('body').css('font-family', font_family);
            }
        });
    });
    var font_url = 'https://fonts.googleapis.com/css?';
    function insertParam2(key, value) {
        key = encodeURIComponent(key);
        value = encodeURIComponent(value);

        var kvp = key + "=" + value;

        var r = new RegExp("(&|\\?)" + key + "=[^\&]*");

        font_url = font_url.replace(r, "$1" + kvp);

        if (!RegExp.$1) { font_url += (font_url.length > 0 ? '&' : '?') + kvp; };

        //again, do what you will here
        return font_url;
    }

})(jQuery);