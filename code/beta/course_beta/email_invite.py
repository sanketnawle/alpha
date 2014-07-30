#!/usr/bin/env python

try:
    import xlrd
except ImportError:
    print "Error importing"
import string
import re
import json

wb = xlrd.open_workbook('testing.xlsx')

for sheet in wb.sheets():
    number_of_columns = sheet.ncols
    number_of_rows = sheet.nrows
    
    values = []

    for col in range(number_of_columns):
        value = (sheet.cell(0, col).value)        
        try:
            value = str(int(value))
        except ValueError:
            pass        
        if('Email' in value):
            email_column_index = col            
            break
    emails = []
    errors = []
    for row in range(1, number_of_rows):
        value = (sheet.cell(row,email_column_index).value)
        try:
            value = str(int(value))            
        except ValueError:
            pass
        if(value.replace(" ", "") == ''):            
            continue
        else:            
            if(re.match("[-!&'*+0-9=?A-Z^_a-z{|}~](\.?[-!&'*+/0-9=?A-Z^_a-z{|}~])*@[a-zA-Z](-?[a-zA-Z0-9])*(\.[a-zA-Z](-?[a-zA-Z0-9])*)+$", value) != None):                
                emails.append(value)
            else:
                errors.append(value)

print json.dumps(emails)
