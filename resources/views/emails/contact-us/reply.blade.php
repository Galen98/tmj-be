<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>

<body style="
    margin:0;
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
        width:100%;
        max-width:600px;
        background:#ffffff;
    "
>

    {{-- HEADER --}}
    <tr>
        <td
            style="
                padding:25px;
                text-align:center;
                border-bottom:1px solid #dddddd;
            "
        >
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
                padding:30px;
                color:#333333;
                line-height:1.6;
            "
        >

            <p>
                Halo {{ $contact->name }},
            </p>


            {{-- ORIGINAL MESSAGE --}}
            <div
                style="
                    margin:25px 0;
                    border-top:1px solid #cccccc;
                    border-bottom:1px solid #cccccc;
                    padding:20px 0;
                "
            >

                <div
                    style="
                        color:#777777;
                        font-size:13px;
                        margin-bottom:15px;
                    "
                >
                    Pesan yang Anda kirim:
                </div>


                <div
                    style="
                        background:#f7f7f7;
                        border-left:4px solid #cccccc;
                        padding:15px;
                    "
                >

                    <strong>
                        {{ $contact->name }}
                    </strong>

                    <div
                        style="
                            color:#777777;
                            font-size:12px;
                            margin-bottom:10px;
                        "
                    >
                        {{ $contact->email }}
                    </div>


                    <div
                        style="
                            white-space:pre-line;
                        "
                    >{{ $contact->message }}</div>

                </div>

            </div>


            {{-- ADMIN REPLY --}}
            <div>

                <div
                    style="
                        font-size:13px;
                        color:#777777;
                        margin-bottom:10px;
                    "
                >
                    Balasan dari Travel Murah Jogja:
                </div>


                <div
                    style="
                        white-space:pre-line;
                    "
                >{{ $reply->message }}</div>

            </div>


            <div
                style="
                    margin-top:30px;
                "
            >
                Salam,
                <br>

                <strong>
                    Customer Care
                    Travel Murah Jogja
                </strong>
            </div>

        </td>
    </tr>


    {{-- FOOTER --}}
    <tr>
        <td
            style="
                padding:20px;
                background:#f7f7f7;
                text-align:center;
                font-size:12px;
                color:#777777;
            "
        >
            Travel Murah Jogja
            <br>
            Teman perjalanan Anda di Yogyakarta.
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>
