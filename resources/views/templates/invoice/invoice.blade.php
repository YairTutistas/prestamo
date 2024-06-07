<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Factura</title>

		<style>
			.invoice-box {
				/* max-width: 400px;
				margin: auto; */
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}

			@page { margin: 0px; }
		</style>
	</head>

	<body style="max-width: 450px">
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img
										src="{{ $payment->logo }}"
										style="width: 100%; max-width: 125px"
									/>
								</td>

								<td>
									Factura #: {{ $payment->id }}<br />
									Generada: {{ date("Y-m-d") }}<br />
									Pagada: {{ $payment->payment_date }}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table cellspacing="0">
							<tr class="heading">
								<td style="padding-bottom: 1px;">Datos Cobrador</td>
								<td style="padding-bottom: 1px;">Datos Cliente</td>
							</tr>
							<tr>
								<td>
									Cobradores S.A<br />
									<!-- Calle siempre viva 123<br /> -->
									{{ $payment->loan->portafolio->getDebtCollector->name }}<br />
									Cali, Colombia
								</td>

								<td>
									{{ $payment->loan->client->name }}<br />
									{{ $payment->loan->client->phone }}<br />
									{{ $payment->loan->client->email }}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Metodo de Pago</td>

					<!-- <td>Efectivo #</td> -->
					<td></td>
				</tr>

				<tr class="details">
					<td>{{$payment->paymentType->name}}</td>

					<!-- <td>1000</td> -->
					<td></td>
				</tr>

				<tr class="heading">
					<td>Razón</td>

					<td>Valor</td>
				</tr>

				<tr class="item">
					<td>Cuota Prestamo</td>

					<td>@moneyformat($payment->amount)</td>
				</tr>

				<tr class="total">
					<td></td>

					<td>Total: @moneyformat($payment->amount)</td>
				</tr>
			</table>
		</div>
	</body>
</html>
