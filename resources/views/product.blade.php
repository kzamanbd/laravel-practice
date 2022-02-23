<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            :root {
                --theme-color: #026cd1;
                --white-color: #ffffff;
                --footer-color: #1b446d;
                --black-color: #000000;
                --text-color: #9b9b9b;
                --para-color: #515151;
                --green-color: rgb(0, 207, 62);
                --blue: #026cd1;
                --white: #ffffff;
                --ice-white: #fbfcfe;
                --bluish-white: #e2edfa;
                --border-color: #e2edfa;
                --red: #fc1130;
                --redish-white: #f5bec6;
                --yellow: #fcc428;
                --yellowish-white: #fff7e3;
                --light-white: #f8f9fa;
                --green: #28a411;
                --greenish-white: #d2fccc;
                --gray: #526471;
                --font64: 64px;
                --font60: 60px;
                --font56: 56px;
                --font52: 52px;
                --font48: 48px;
                --font44: 44px;
                --font40: 40px;
                --font36: 36px;
                --font34: 34px;
                --font32: 32px;
                --font30: 30px;
                --font28: 26px;
                --font26: 26px;
                --font24: 24px;
                --font22: 22px;
                --font20: 20px;
                --font18: 18px;
                --font16: 16px;
                --font14: 14px;
                --font12: 12px;
                --font10: 10px;
                --font100: 100;
                /*--thin--*/
                --font200: 200;
                /*--extra light--*/
                --font300: 300;
                /*--light--*/
                --font400: 400;
                /*--regular--*/
                --font500: 500;
                /*--medium--*/
                --font600: 600;
                /*--semi bold--*/
                --font700: 700;
                /*--bold--*/
                --font800: 800;
                /*--extra bold--*/
                --font900: 900;
                /*--black--*/
            }

            @media only screen and (max-width: 767px) {
                :root {
                    --font14: 13px;
                    --font12: 11px;
                    --font10: 9px;
                }
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            p {
                margin: 0;
            }


            /* Start Sidebar Style  */

            #sidebar {
                position: fixed;
                top: 0;
                padding: 30px 25px;
                right: -500px;
                width: 500px;
                height: 100vh;
                background: var(--light-white);
                transition: 0.5s;
                z-index: 10000000000000000;
            }

            #sidebar.active {
                right: 0px;
            }


            /* #sidebar #close-btn {
                cursor: pointer;
            } */

            #sidebar #close-btn i {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 35px;
                height: 35px;
                font-size: var(--font28);
                color: var(--blue);
                border-radius: 100px;
                background-color: var(--bluish-white);
                cursor: pointer;
                padding: 22px;
            }

            #sidebar #close-btn i:hover {
                font-size: var(--font28);
                color: var(--bluish-white);
                background-color: var(--red);
                transition: 0.5s;
            }

            #sidebar .product {
                padding-top: 50px;
                height: calc(100vh - 100px);
            }

            #sidebar .product h3 {
                color: var(--theme-color);
                padding-bottom: 20px;
                font-weight: 500;
            }

            #sidebar .product .search-box {
                display: flex;
                flex-direction: column;
            }

            #sidebar .product .search-box .select-product {
                display: flex;
                flex-direction: column;
            }

            #sidebar .product .search-box .select-product select {
                outline: none;
                box-shadow: none;
                border: 1px solid #ced4da;
                height: 42px !important;
            }

            #sidebar .product .search-box .select-product option {
                width: 100%;
            }

            #sidebar .product .search-box .select-product select:hover {
                box-shadow: var(--blue);
            }

            #sidebar .product .search-box .input {
                display: flex;
                flex-direction: row;
            }

            #sidebar .product .search-box input {
                border: 1px solid #ced4da;
                border-radius: 0%;
            }

            #sidebar .product .search-box input#placeholder {
                box-shadow: none;
            }

            #sidebar .product .search-box .btn {
                width: 150px;
                border-radius: 0;
                color: #ffff;
                background-color: #026cd1;
            }

            #sidebar .product .search-box .btn:focus {
                outline: none;
                box-shadow: none;
            }

            #sidebar .product .list-product {
                display: flex;
                justify-content: start;
                flex-direction: column;
                padding-top: 20px;
                height: calc(100% - 165px);
                /* background-color: aquamarine; */
            }

            #sidebar .product .list-product .product-img img {
                height: 120px;
            }

            #sidebar .product .product-content {
                height: 100%;
                display: flex;
                /* justify-content: space-between; */
                margin: 15px 0;
                flex-direction: column;
                /* overflow-y: scroll; */
            }

            #sidebar .product .list-product .head {
                font-size: var(--font16);
                font-weight: 500;
                color: var(--theme-color);
                margin: 10px 0;
            }

            #sidebar .product .list-product .batch span {
                color: var(--green-color);
                font-weight: 500;
            }

            #sidebar .product .empty-product {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                height: calc(100% - 165px);
            }

            #sidebar .text-title {
                font-size: var(--font10);
                margin: 15px 0;
            }

            @media only screen and (max-width: 767px) {
                #sidebar {
                    right: -100%;
                    width: 100%;
                }
            }


            /* End Sidebar Style */
        </style>

    </head>
    <body>
        <div id="toggle">Verify Product</div>
        <div id="sidebar" class="active">
            <!--class="active" -->
            <span id="close-btn"><i id="close" class="fa fa-times" aria-hidden="true" title="Close"></i></span>
    
            <div class="product">
    
                <h3>Verify Product {{ request()->sbu_id ?? '' }}</h3>
    
                <!-- Start Search Box -->
                <div class="search-box">
                    <div class="select-product">
                        <label for="">Product Name</label>
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="input">
                        <input id="placeholder" type="text" placeholder="Enter product number" class="form-control">
                        <button type="button" class="btn btn-secondary">Check</button>
                    </div>
                </div>
                <!-- End Search Box -->
    
                <!-- Start List Product -->
                <div class="list-product ">
                    <p class="product-img">
                        <img src="{{ asset('images/product-01.png') }}" alt="">
                    </p>
                    <div class="product-content">
                        <div>
                            <p class="head">Lijenta-MX 5 5mg + 1000mg ER Tablet</p>
                            <p class="text-title">
                                Increased risk of hypoglycaemia when used w/ an insulin secretagogue (e.g. sulfonylurea) or insulin. Plasma concentration of linagliptin may be decreased by strong inducers of P-glycoprotein (e.g. rifampicin) and may be increased by strong P-glycoprotein
                                inhibitors (e.g. ritonavir).
                            </p>
                        </div>
                        <p class="batch text-title">Batch Authenticity:&nbsp;<span>Authentic</span></p>
                    </div>
                </div>
                <!-- End List Product -->
    
                <!-- Start Empty Product -->
                <div class="empty-product d-none">
                    <img src="./img/empty-product.png" alt="Product Not Found">
                    <p>OOPS! Product not found</p>
                </div>
                <!-- End Empty Product -->
    
            </div>
    
        </div>
        <script>
            // Start Sidebar
    
            // toggle Animation
            let toggle = document.querySelector('#toggle');
    
            toggle.onclick = function() {
                toggle.classList.toggle('active');
                sidebar.classList.toggle('active');
            }
    
            let close = document.querySelector('#close');
            close.onclick = function() {
                toggle.classList.toggle('active');
                sidebar.classList.toggle('active');
            }
    
    
            // End Sidebar
        </script>
    </body>
    
</html>
