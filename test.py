import sys
import pandas as pd
import seaborn as sns
import numpy as py
import matplotlib.pyplot as plt

from prophet import Prophet

from pandas.plotting import register_matplotlib_converters
register_matplotlib_converters()

%matplotlib inline
%config InlineBackend.figure_format='retina'

file = open('water_detail.csv')
data= pd.read_csv(file, parse_dates=['date'], skipinitialspace=True)
data=data.sort_values('date').reset_index(drop=True).copy()
y_col='aow'
data.dropna(subset=[y_col], inplace=True)
df=data[['date', y_col]]
df.columns=['ds','y']
model=Prophet()
model.fit(df)
future=model.make_future_dataframe(periods=275, freq='D')
forecast=model.predict(future)
dfcst=forecast[['ds', 'yhat', 'yhat_lower', 'yhat_upper']]
dt=pd.merge(df, dfcst, left_on='ds', right_on='ds')
dt.shape
fig=model.plot(forecast, uncertainty=True, figsize=(16, 9), xlabel='date', ylabel='amount of water')
plt.title(f'Kwan Phayao')

tmpfile = BytesIO()
fig.savefig(tmpfile, format='png')
encoded = base64.b64encode(tmpfile.getvalue()).decode('utf-8')
st1 = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Water Detail</title><script src="my_chart.js"></script><link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"><script src="https://code.jquery.com/jquery-1.12.4.js"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script><script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script><link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"><link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css" /><link rel="stylesheet" href="style_index.css"><script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script><script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script><script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script><link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script></head>'
st2 = '<body><div class="container"><div class="container d-flex flex-wrap"><ul class="nav me-auto align-items-center mt-2"><img src="img/ict_tran.png" height="60" width="60"><a class="navbar-brand ms-3 " href="Homepage/homepage.html">???????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????</a></ul><ul class="nav mt-3"><li class="nav-item"><a href="Homepage/homepage.html" class="nav-link link-dark px-2 active" aria-current="page">?????????????????????</a></li><li class="nav-item"><a href="Contract/contract.html" class="nav-link link-dark px-2">??????????????????</a></li><li class="nav-item"><a href="About/about.html" class="nav-link link-dark px-2">????????????????????????????????????</a></li><li class="nav-item"><a href="login.php" class="nav-link link-dark px-2">????????????????????????????????????</a></li></ul></div></nav>'
st3 = ' <div class="row"><script src="https://cdn.jsdelivr.net/npm/chart.js"></script><script src="https://cdn.jsdelivr.net/npm/chart.js"></script><main class="my-4"> <div class="col-xl-12"><div class="mb-4"><h4 class="text-center">????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????</h4><img src="img/graphforecast.png" height="80%" width="80%" class="mx-auto d-block"></div></div><div class="col-xl-12"><div class="mb-4"><h4 class="text-center">??????????????????????????????????????????????????????????????? 1 ??????</h4><img src="img/components_year.png" height="80%" width="80%" class="mx-auto d-block"></div></div></main></div></div>'
st4 = '<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script><script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script><script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script><script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>  </body></html>'
html = st1 + st2 + '<img src=\'data:image/png;base64,{}\'>'.format(encoded) + st3 + st4

with open('test.html','w') as f:
    f.write(html)
file = codecs.open("test.html", 'r', "utf-8")

# using .read method to view the html 
# code from our object
# print(file.read())