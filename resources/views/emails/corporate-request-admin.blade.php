@extends('emails.layouts.app')


@section('content')

    <h2
        style="
            margin: 0 0 10px;
            color: #222222;
            font-size: 20px;
        "
    >
        Pengajuan Paket Korporasi Baru
    </h2>


    <p
        style="
            margin-top: 0;
            color: #666666;
        "
    >
        Terdapat pengajuan paket korporasi baru
        dari customer.
    </p>


    <div
        style="
            margin-top: 25px;
            padding: 20px;
            background-color: #f7f8fa;
            border-radius: 6px;
        "
    >

        <table
            width="100%"
            cellpadding="8"
            cellspacing="0"
            border="0"
            style="
                font-size: 13px;
            "
        >

            <tr>

                <td
                    width="40%"
                    style="
                        color: #777777;
                    "
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
                    WhatsApp
                </td>

                <td>
                    {{ $corporateRequest->whatsapp }}
                </td>

            </tr>


            <tr>

                <td style="color: #777777;">
                    Email
                </td>

                <td>
                    {{ $corporateRequest->email }}
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


            <tr>

                <td style="color: #777777;">
                    Waktu Pengajuan
                </td>

                <td>
                    {{
                        $corporateRequest
                            ->created_at
                            ->format('d M Y H:i')
                    }}
                </td>

            </tr>

        </table>

    </div>


    <p
        style="
            margin-top: 25px;
            margin-bottom: 0;
            color: #666666;
        "
    >
        Silakan cek halaman admin Travel Murah Jogja
        untuk melihat detail pengajuan.
    </p>

@endsection
