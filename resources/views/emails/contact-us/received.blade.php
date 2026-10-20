<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>
        Terima Kasih Telah Menghubungi Kami
    </title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#f5f5f5;
    font-family:Arial,sans-serif;
">

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
>
<tr>
<td
    align="center"
    style="padding:30px 15px;"
>

<table
    width="600"
    cellpadding="0"
    cellspacing="0"
    style="
        max-width:600px;
        width:100%;
        background:#ffffff;
    "
>

    {{-- HEADER --}}
    <tr>
        <td
            style="
                padding:25px;
                text-align:center;
                border-bottom:1px solid #eeeeee;
            "
        >

            {{-- gunakan logo TMJ kamu --}}
            <img
                src="{{ asset('images/misc/icon.png') }}"
                alt="Travel Murah Jogja"
                width="70"
                style="
                    display:block;
                    max-width:70px;
                    height:auto;
                "
            >

        </td>
    </tr>


    {{-- CONTENT --}}
    <tr>
        <td
            style="
                padding:35px;
                color:#333333;
                line-height:1.7;
            "
        >

            <h2>
                Halo {{ $contact->name }},
            </h2>

            <p>
                Terima kasih telah menghubungi
                Travel Murah Jogja.
            </p>

            <p>
                Pesan Anda telah kami terima.
                Tim kami akan segera memeriksa
                pesan Anda dan menghubungi Anda
                kembali melalui email ini.
            </p>


            <div
                style="
                    margin:25px 0;
                    padding:20px;
                    background:#f7f7f7;
                    border-left:4px solid #dddddd;
                "
            >

                <strong>
                    Pesan Anda:
                </strong>

                <p
                    style="
                        margin-bottom:0;
                        white-space:pre-line;
                    "
                >{{ $contact->message }}</p>

            </div>


            <p>
                Salam,
                <br>

                <strong>
                    Travel Murah Jogja
                </strong>
            </p>

        </td>
    </tr>


    {{-- FOOTER --}}
    <tr>
        <td
            style="
                padding:20px;
                text-align:center;
                background:#f7f7f7;
                color:#777777;
                font-size:12px;
            "
        >

            Email ini dikirim karena Anda
            menghubungi Travel Murah Jogja
            melalui halaman Contact Us.

        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>
