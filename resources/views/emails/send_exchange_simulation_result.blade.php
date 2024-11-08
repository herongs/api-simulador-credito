<!DOCTYPE html>
<html>

<head>
    <title>Sua Cotação de Crédito - Câmbio</title>
</head>

<body>
    <div style="font-family: Roboto, sans-serif; max-width: 600px; margin: 0 auto">
        <div style="padding: 20px; border-radius: 8px;">
            <h2>Simulation Finance - Simulador de Crédito com Câmbio</h2>
        </div>
        <div style="padding: 20px;">
            <h3>Olá,</h3>

            <p>Aqui está a simulação de crédito que você solicitou:</p>

            <p>
                Valor inicial do empréstimo em Real: <b>R$ {{ $dto->loan_amount }}</b><br>
                Taxa de Câmbio: <b>R$ 1,00 = {{ $simulation->currency }} {{ number_format($exchangeRate->rate, 2, ',', '.') }}</b><br>
            </p>

            <p>
                Valor do empréstimo: <b>{{ $simulation->currency }} {{ number_format($simulation->loan_amount, 2, ',', '.') }} </b><br>
                Quantidade de parcelas: <b>{{ $simulation->payment_date }}</b><br>
                Taxa de juros ao ano: <b>{{ $simulation->interest_rate }}% {{ $simulation->interest_type == 'VARIAVEL' ? '(Variável)' : '(Fixa)' }}</b>

            </p>

            <p>Abaixo estão os detalhes do valor total a pagar e os valores das parcelas:</p>

            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px;">Descrição</th>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px;">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">Total a pagar</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $simulation->currency }} {{ number_format($simulation->total_payment, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">Valor da parcela mensal</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $simulation->currency }} {{ number_format($simulation->monthly_payment, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Total de juros</td>
                        <td style="padding: 8px;">{{ $simulation->currency }} {{ number_format($simulation->total_interest, 2, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <p>Se tiver alguma dúvida, estamos à disposição para ajudar.</p>

            <p>Atenciosamente,</p>
            <p><b>Equipe Simulation Finance</b></p>
        </div>
    </div>
</body>

</html>
