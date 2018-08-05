
<html moznomarginboxes mozdisallowselectionprint>
    <head>
        <title>
            E-POS Kedai Argyta
        </title>
        <style type="text/css">
			@font-face {
			    font-family: 'monaco'; /*a name to be used later*/
			    src: url('<?php echo base_url("assets/dist/css/monaco.ttf") ?>'); /*URL to font*/
			}
            html {
                font-family: Arial !important;
            }
            .content {
                width: 38mm;
                font-size: 10px;
                margin-bottom: 20px;
                background-image: url('<?php echo base_url('assets/logot.png'); ?>');    
                background-repeat: no-repeat;
                background-position: center;
                background-size: 120px;
            }
            .content .title {
                text-align: center;
            }
            .content .title .slogan {
                text-align: center;
                font-size: 6pt;
            }
            .content .head-desc {
                margin-top: 20px;
                display: table;
                width: 100%;
                font-size: 8.5px;
            }
            .content .head-desc > div {
                display: table-cell;
            }
            .content .head-desc .user {
                text-align: right;
            }
            .content .nota {
                text-align: center;
                margin-top: 5px;
                margin-bottom: 5px;
            }
            .content .separate {
                margin-top: 20px;
                margin-bottom: 15px;
                border-top: 1px dashed #000;
            }
            .content .transaction-table {
                width: 100%;
                font-size: 8px;
            }
            .content .transaction-table .name {
                width: 185px;
            }
            .content .transaction-table .qty {
                text-align: center;
            }
            .content .transaction-table .sell-price, .content .transaction-table .final-price {
                text-align: right;
                width: 65px;
            }
            .content .transaction-table tr td {
                vertical-align: top;
                font-size: 9px;
            }
            .content .transaction-table .price-tr td {
                padding-top: 5px;
                padding-bottom: 7px;
            }
            .content .transaction-table .discount-tr td {
                padding-top: 7px;
                padding-bottom: 7px;
            }
            .content .transaction-table .separate-line {
                height: 1px;
                border-top: 1px dashed #000;
            }
            .content .thanks {
                margin-top: 25px;
                text-align: center;
                font-family: 'monaco', sans-serif !important;
            }
            .content .azost {
                margin-top:5px;
                text-align: center;
            }
            @media print {
                @page  { 

                    margin: 0mm;
                }
            }

        </style>
    </head>
    <?php $date = new DateTime($transaction->date) ?>
    <body <?php if($this->input->get('print')) echo 'onload="window.print();"'; ?>><!-- window.print(); -->
        <div class="content">
            <div class="title">
                <strong>KEDAI ARGYTA</strong><br><i class="slogan">Jl. Horman Maddati No. 66,  Pangkalpinang</i>
            </div>
            <div class="head-desc">
                <div class="date"><?php echo $date->format('d/m/Y H:i A'); ?><br><?php echo "No.".$transaction->ID_transaction; ?></div>
                <div class="user"><?php echo $this->account->name; ?></div>
            </div>
            <div class="separate"></div>
            <div class="transaction">
                <table class="transaction-table" cellspacing="0" cellpadding="0">
                <?php foreach ( $product as $row ) : ?>
                    <tr>
                      <td class='name'><?php echo $row->product_name; ?></td>
                      <td class='qty'><?php echo $row->quantity; ?></td>  
                      <td class='sell-price'><?php echo number_format($row->price); ?></td>  
                      <td class='final-price'><?php echo number_format($row->price * $row->quantity); ?></td>
                    </tr>                    
                    <tr class="price-tr">
                      <td colspan="4"><div class="separate-line"></div></td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="final-price">HARGA JUAL</td>
                        <td class="final-price"><?php echo number_format($transaction->total); ?></td>
                    </tr>
                    <tr class="price-tr">
                      <td colspan="4"><div class="separate-line"></div></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="final-price">TOTAL</td>
                        <td class="final-price"><?php echo number_format($transaction->total); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="final-price"> BAYAR</td>
                        <td class="final-price"><?php echo number_format($transaction->paid); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="final-price">KEMBALI</td>
                        <td class="final-price"><?php echo number_format($transaction->paid - $transaction->total); ?></td>
                    </tr>
                </table>
            </div>
            <div class="thanks" style="padding-bottom: 30px;">
                ~~~ Terima Kasih ~~~
            </div>
        </div>
    </body>
</html>