@extends('emails.layouts.app')


@section('content')

    <h2
        style="
            margin: 0 0 20px;
            color: #222222;
            font-size: 20px;
        "
    >
        Permintaan Anda Telah Kami Terima
    </h2>


    <p>
        Halo,
    </p>


    <p>
        Terima kasih telah menghubungi
        <strong>Travel Murah Jogja</strong>.
    </p>


    <p>
        Permintaan paket korporasi Anda telah kami terima.
        Kami akan mempelajarinya dan segera menghubungi
        Anda secepatnya melalui email atau WhatsApp
        yang telah Anda cantumkan.
    </p>


    {{-- SUMMARY --}}

    <div
        style="
            margin: 25px 0;
            padding: 20px;
            background-color: #f7f8fa;
            border-radius: 6px;
        "
    >

        <div
            style="
                margin-bottom: 15px;
                font-size: 15px;
                font-weight: bold;
                color: #222222;
            "
        >
            Ringkasan Permintaan
        </div>


        <table
            width="100%"
            cellpadding="5"
            cellspacing="0"
            border="0"
            style="
                font-size: 13px;
            "
        >

            <tr>

                <td
                    width="45%"
                    style="color: #777777;"
                >
                    Nama Perusahaan
                </td>

                <td>
                    <strong>
                        {{ $corporateRequest->company_name }}
                    </strong>
                </td>

            </tr>


            <tr>

                <td style="color: #777777;">
                    Durasi Acara
                </td>

                <td>
                    {{ $corporateRequest->duration_days }}
                    Hari
                </td>

            </tr>


            <tr>

                <td style="color: #777777;">
                    Jumlah Peserta
                </td>

                <td>
                    {{ $corporateRequest->participant_count }}
                    Orang
                </td>

            </tr>


            <tr>

                <td style="color: #777777;">
                    Include Hotel
                </td>

                <td>
                    {{
                        $corporateRequest->include_hotel
                            ? 'Ya'
                            : 'Tidak'
                    }}
                </td>

            </tr>


            <tr>

                <td style="color: #777777;">
                    Keberangkatan
                </td>

                <td>
                    {{ $corporateRequest->departure_location }}
                </td>

            </tr>

        </table>

    </div>


    <p
        style="
            margin-bottom: 0;
        "
    >
        Salam,<br>

        <strong>
            Tim Travel Murah Jogja
        </strong>
    </p>

@endsection
