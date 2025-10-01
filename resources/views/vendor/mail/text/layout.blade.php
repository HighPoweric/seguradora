<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f8fafc;
            padding: 20px 0;
        }
        .content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        .inner-body {
            padding: 32px;
        }
        .footer {
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0">
                    {{-- Header opcional --}}
                    @isset($header)
                        {{ $header }}
                    @endisset

                    {{-- Contenido principal (Markdown parseado) --}}
                    <tr>
                        <td class="inner-body">
                            {!! Illuminate\Mail\Markdown::parse($slot) !!}
                        </td>
                    </tr>

                    {{-- Subcopy opcional --}}
                    @isset($subcopy)
                        <tr>
                            <td class="inner-body">
                                {!! Illuminate\Mail\Markdown::parse($subcopy) !!}
                            </td>
                        </tr>
                    @endisset

                    {{-- Footer --}}
                    @isset($footer)
                        {{ $footer }}
                    @else
                        <tr>
                            <td class="footer">
                                © {{ date('Y') }} Equipo de Liquidaciones.
                            </td>
                        </tr>
                    @endisset
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
