#!/usr/bin/env python

import cfscrape
import sys

who = sys.argv[1]
scraper = cfscrape.create_scraper() 
print scraper.get(who).content
