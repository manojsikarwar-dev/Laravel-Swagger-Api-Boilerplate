@extends('mail.layout.layout')
@section('content')
<tr>
	<td style="padding: 0 30px 30px; font-family: 'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; font-size: 11pt; line-height: 27px; color: #444; text-align: left;">
		<p style="margin: 0;">Please verify email to login </p>
	</td>
</tr>
<tr>
	<td style="padding: 0 30px 30px; font-family: 'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; font-size: 11pt; line-height: 27px; color: #444;">
		<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: auto;">
			<tr>
				<td style="border-radius: 5px; background: #D19C97; text-align: center; padding: 10px 20px;" class="button-td">
					<a href="{{ $data['url'] }}" style="background: #D19C97; font-family: 'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; font-size: 11pt; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 5px; font-weight: bold;" class="button-a">
						<span style="color:white;" class="button-link">Verify Email</span>
					</a>
				</td>
			</tr>
		</table>
	</td>
</tr>
@stop