#!/usr/bin/env python

try:
    import xlrd
except ImportError:
    print "Error importing"
import string
import re
import json
import sys
import os

arguments = sys.argv
file_name = arguments[1]

emails = []
errors = []

wb = xlrd.open_workbook(file_name)

for sheet in wb.sheets():
    number_of_columns = sheet.ncols
    number_of_rows = sheet.nrows

    if number_of_columns > 1000:
        number_of_columns = 1000
    if number_of_rows > 1000:
        number_of_rows = 1000

    for col in range(number_of_columns):
        for row in range(number_of_rows):
            value = (sheet.cell(row, col).value)
            value = str(value)
            if value.replace(" ", "") == '':
                continue
            else:
                emails.append(value)

os.remove(file_name)
print json.dumps(emails)
