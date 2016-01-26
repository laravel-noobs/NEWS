@extends('emails.partials._layout')

@section('content')
<div class="block">
    <!-- image + text -->
    <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="bigimage">
        <tbody>
        <tr>
            <td>
                <table bgcolor="#ffffff" width="580" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" modulebg="edit">
                    <tbody>
                    <tr>
                        <td width="100%" height="20"></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="540" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                <tbody>
                                <tr>
                                    <!-- start of image -->
                                    <td align="center">
                                        @yield('simple_email_banner')

                                    </td>
                                </tr>
                                <!-- end of image -->
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="20"></td>
                                </tr>
                                <!-- Spacing -->
                                <!-- title -->
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:left;line-height: 20px;" st-title="rightimage-title">
                                        @yield('simple_email_title')
                                    </td>
                                </tr>
                                <!-- end of title -->
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="20"></td>
                                </tr>
                                <!-- Spacing -->
                                <!-- content -->
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #95a5a6; text-align:left;line-height: 24px;" st-content="rightimage-paragraph">
                                        @yield('simple_email_content')
                                    </td>
                                </tr>
                                <!-- end of content -->
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="10"></td>
                                </tr>
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="20"></td>
                                </tr>
                                <!-- Spacing -->
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>
@endsection