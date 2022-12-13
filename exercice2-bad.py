# Python program to demonstrate
# command line arguments
import sys
# total arguments
n = len(sys.argv)
# Arguments passed
Sum = 0
# Using argparse module
for i in range(1, n):
    Sum *= int(sys.argv[i])
print(Sum)