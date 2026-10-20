<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Travel Murah Jogja
    </title>

</head>

<body
    style="
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
        font-family: Arial, Helvetica, sans-serif;
        color: #333333;
    "
>

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        width: 100%;
        background-color: #f5f5f5;
        padding: 30px 15px;
    "
>

    <tr>

        <td align="center">

            <table
                width="600"
                cellpadding="0"
                cellspacing="0"
                border="0"
                style="
                    width: 100%;
                    max-width: 600px;
                    background-color: #ffffff;
                    border-radius: 8px;
                    overflow: hidden;
                "
            >

                {{-- ========================= --}}
                {{-- HEADER --}}
                {{-- ========================= --}}

                <tr>

                    <td
                        align="center"
                        style="
                            padding: 25px 30px;
                            border-bottom: 1px solid #eeeeee;
                        "
                    >

                        <img
                            src="{{ asset('images/misc/icon.png') }}"
                            alt="Travel Murah Jogja"
                            width="80"
                            style="
                                display: block;
                                width: 80px;
                                max-width: 80px;
                                height: auto;
                                border: 0;
                            "
                        >

                    </td>

                </tr>


                {{-- ========================= --}}
                {{-- CONTENT --}}
                {{-- ========================= --}}

                <tr>

                    <td
                        style="
                            padding: 30px;
                            font-size: 14px;
                            line-height: 1.7;
                        "
                    >

                        @yield('content')

                    </td>

                </tr>


                {{-- ========================= --}}
                {{-- FOOTER --}}
                {{-- ========================= --}}

                <tr>

                    <td
                        align="center"
                        style="
                            padding: 22px 30px;
                            border-top: 1px solid #eeeeee;
                            background-color: #fafafa;
                            color: #888888;
                            font-size: 12px;
                            line-height: 1.6;
                        "
                    >

                        <strong
                            style="
                                color: #333333;
                            "
                        >
                            Travel Murah Jogja
                        </strong>

                        <br>

                        Partner perjalanan wisata Anda.

                        <br><br>

                        Email ini dikirim secara otomatis.
                        Mohon tidak membalas email ini.

                    </td>

                </tr>

            </table>

        </td>

    </tr>

</table>

</body>

</html>
